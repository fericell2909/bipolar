<?php

namespace App\Instances;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;

class CartBipolar
{
    /** @var \Illuminate\Database\Eloquent\Model|Cart $cart */
    private $cart;
    private $relationships = [
        'details',
        'details.product.subtypes',
        'details.product.photos',
        'details.stock.size',
    ];

    public function __construct()
    {
        if (\Auth::check()) {
            $this->cart = Cart::firstOrCreate(['user_id' => \Auth::id()]);
        } else {
            $this->cart = Cart::firstOrCreate(['session_id' => \Session::getId()]);
        }

        // Destroy another instances
        try {
            Cart::whereKeyNot($this->cart->id)
                ->where('user_id', $this->cart->user_id)
                ->where('session_id', $this->cart->session_id)
                ->delete();
        } catch (\Exception $e) {
            dd($e);
        }

        $this->cart->loadMissing($this->relationships);
    }

    /**
     * @param int $quantity
     * @param Product $product
     * @param null $stockId
     * @return CartDetail
     */
    public function add(int $quantity, Product $product, $stockId = null): CartDetail
    {
        /** @var CartDetail $cartDetail */
        $cartDetail = CartDetail::firstOrCreate([
            'cart_id'    => $this->cart->id,
            'product_id' => $product->id,
            'stock_id'   => $stockId,
        ]);

        $pricePEN = $cartDetail->product->discount_pen ? $cartDetail->product->price_pen_discount : $cartDetail->product->price;
        $priceUSD = $cartDetail->product->discount_usd ? $cartDetail->product->price_usd_discount : $cartDetail->product->price_dolar;
        $cartDetail->quantity = $cartDetail->quantity + $quantity;
        $cartDetail->total = $pricePEN * $cartDetail->quantity;
        $cartDetail->total_dolar = $priceUSD * $cartDetail->quantity;
        $cartDetail->save();

        $this->recalculate();

        return $cartDetail;
    }

    /**
     * Return the last cart
     *
     * @return Cart
     */
    public function last()
    {
        return $this->cart;
    }

    /**
     * @return Cart
     */
    public function model(): Cart
    {
        return $this->cart;
    }

    public function id()
    {
        return (is_null($this->cart)) ? null : $this->cart->id;
    }

    public function count()
    {
        if (is_null($this->cart)) {
            return 0;
        }

        return $this->cart->details->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function content()
    {
        if ($this->count() === 0) {
            return [];
        }

        $this->cart->details->each(function ($detail) {
            /** @var CartDetail $detail */
            if (blank($detail->product)) {
                return $detail->delete();
            }

            return;
        });

        $this->recalculate();

        $this->cart->loadMissing($this->relationships);

        return $this->cart->details;
    }

    public function totalCurrency()
    {
        return $this->cart->total_currency;
    }

    /**
     * @param Cart $cart
     * @param User $user
     * @return Cart
     */
    public function convertToUser(Cart $cart, User $user)
    {
        $cart->session_id = null;
        $cart->user()->associate($user);
        $cart->save();

        return $cart;
    }

    public function recalculate()
    {
        $this->cart = $this->cart->fresh();

        if (empty($this->cart)) {
            return;
        }

        if ($this->cart->details->count() === 0) {
            $this->cart->subtotal = 0;
            $this->cart->subtotal_dolar = 0;
            $this->cart->total = 0;
            $this->cart->total_dolar = 0;

            return $this->cart->save();
        }

        if ($this->hasCoupon()) {
            return $this->recalculateWithCoupon($this->cart->coupon);
        }

        $total = $this->cart->details->sum('total');
        $totalDolar = $this->cart->details->sum('total_dolar');

        $this->cart->subtotal = $total;
        $this->cart->subtotal_dolar = $totalDolar;
        $this->cart->total = $total;
        $this->cart->total_dolar = $totalDolar;

        return $this->cart->save();
    }

    public function remove($productSlug)
    {
        $this->cart->details->each(function ($detail) use ($productSlug) {
            return $detail->product->slug === $productSlug ? $detail->delete() : false;
        });

        $this->recalculate();

        return true;
    }

    public function destroy()
    {
        $this->cart->details->each(function ($detail) {
            return $detail->delete();
        });

        $this->cart->delete();

        $this->recalculate();

        return true;
    }

    public function getSubtotalBySessionCurrency(): float
    {
        return \Session::get('BIPOLAR_CURRENCY', 'USD') === 'USD' ? $this->cart->subtotal_dolar : $this->cart->subtotal;
    }

    public function getTotalBySessionCurrency(): float
    {
        return \Session::get('BIPOLAR_CURRENCY', 'USD') === 'USD' ? $this->cart->total_dolar : $this->cart->total;
    }

    /**
     * @param Coupon $coupon
     * @return Cart|\Illuminate\Database\Eloquent\Model
     */
    private function recalculateWithCoupon(Coupon $coupon)
    {
        $discountPEN = 0;
        $discountUSD = 0;
        if ($coupon->type_id === config('constants.PERCENTAGE_DISCOUNT_ID')) {
            // Sub the percentage
            $detailsInCoupon = $this->cart->details->filter($this->detailsInCoupon($coupon));
            $percentagePEN = calculate_percentage($detailsInCoupon->sum('total'), $coupon->amount_pen);
            $percentageUSD = calculate_percentage($detailsInCoupon->sum('total_dolar'), $coupon->amount_usd);
            $discountPEN = $detailsInCoupon->sum('total') - $percentagePEN > 0 ? $percentagePEN : $detailsInCoupon->sum('total');
            $discountUSD = $detailsInCoupon->sum('total_dolar') - $percentageUSD > 0 ? $percentageUSD : $detailsInCoupon->sum('total_dolar');
        } elseif ($coupon->type_id === config('constants.QUANTITY_DISCOUNT_ID')) {
            // Sum all products in coupon and sub the total amount
            /** @var Collection $detailsInCoupon */
            $detailsInCoupon = $this->cart->details->filter($this->detailsInCoupon($coupon));
            $discountPEN = $detailsInCoupon->sum('total') - $coupon->amount_pen > 0 ? $coupon->amount_pen : $detailsInCoupon->sum('total');
            $discountUSD = $detailsInCoupon->sum('total_dolar') - $coupon->amount_usd > 0 ? $coupon->amount_usd : $detailsInCoupon->sum('total_dolar');
        }

        $total = $this->cart->details->sum('total');
        $totalDolar = $this->cart->details->sum('total_dolar');

        $this->cart->discount_coupon_pen = $discountPEN;
        $this->cart->discount_coupon_usd = $discountUSD;
        $this->cart->subtotal = $total - $discountPEN;
        $this->cart->subtotal_dolar = $totalDolar - $discountUSD;
        $this->cart->total = $total - $discountPEN;
        $this->cart->total_dolar = $totalDolar - $discountUSD;
        $this->cart->save();

        return $this->cart;
    }

    /**
     * @param Coupon $coupon
     * @return Cart|\Illuminate\Database\Eloquent\Model
     */
    public function addCoupon(Coupon $coupon)
    {
        $this->cart->coupon()->associate($coupon);

        return $this->recalculateWithCoupon($coupon);
    }

    /**
     * Filter details for check if it is contained in the coupon
     *
     * @param Coupon $coupon
     * @return \Closure
     */
    private function detailsInCoupon(Coupon $coupon)
    {
        return function ($detail) use ($coupon) {
            /** @var CartDetail $detail */
            // Check if coupon has discount and remove if it doesn't support
            if (boolval($coupon->discounted_products) === false) {
                if ($detail->product->hasOwnDiscount()) {
                    return false;
                }
            }

            $detailInCouponProducts = in_array($detail->product_id, $coupon->products ?? []);
            $detailInCouponSubtypes = count(array_intersect($coupon->product_subtypes ?? [], $detail->product->subtypes->pluck('id')->toArray())) > 0;
            $detailInCouponTypes = count(array_intersect($coupon->product_types ?? [], $detail->product->subtypes->groupBy('type_id')->keys()->toArray())) > 0;

            return $detailInCouponProducts || $detailInCouponSubtypes || $detailInCouponTypes;
        };
    }

    public function removeCoupon()
    {
        $this->cart->coupon()->dissociate();

        return $this->recalculate();
    }

    public function hasCoupon()
    {
        return !is_null($this->cart->coupon_id);
    }

    /**
     * @return Coupon|bool
     */
    public function getCoupon()
    {
        if (!$this->hasCoupon()) {
            return false;
        }

        return $this->cart->coupon;
    }

    public function getCouponDiscountByCurrency(string $currency)
    {
        $couponDiscount = null;

        switch ($currency) {
            case 'USD';
                $couponDiscount = $this->cart->discount_coupon_usd;
                break;
            case 'PEN';
                $couponDiscount = $this->cart->discount_coupon_pen;
                break;
        }

        return $couponDiscount;
    }
}
