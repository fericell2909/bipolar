<?php

namespace App\Instances;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Auth;
use Closure;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Log;
use Session;

class CartBipolar
{
    /** @var Model|Cart $cart */
    private $cart;
    private static $instance = null;
    private $relationships = [
        'details',
        'details.product',
        'details.product.subtypes',
        'details.product.photos',
        'details.stock.size',
    ];

    private function __construct()
    {
        $this->init();
    }

    private function init()
    {
        if (Auth::check()) {
            $this->cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $this->cart = Cart::firstOrNew(['session_id' => Session::getId()]);
        }

        // Destroy another instances
        if ($this->cart->user_id) {
            try {
                $anotherCart = Cart::whereUserId($this->cart->user_id)->whereNotIn('id', [$this->cart->id])->with('details')->first();
                if ($anotherCart) {
                    Log::info("Carro {$anotherCart->id} encontrado, borrando {$this->cart->id}");
                    if ($this->cart->details->isNotEmpty()) {
                        CartDetail::whereCartId($this->cart->id)->delete();
                    }
                    $this->cart->delete();
                    $this->cart = $anotherCart;
                }
            } catch (Exception $e) {
                Log::error($e);
            }
        }

        $this->cart->loadMissing($this->relationships);
        $this->recalculate();
    }

    private function __clone()
    {
        // Prevent cloning
    }

    public static function getInstance(): CartBipolar
    {
        if (is_null(self::$instance)) {
            self::$instance = new CartBipolar();
        }

        return self::$instance;
    }

    /**
     * @param int $quantity
     * @param Product $product
     * @param null $stockId
     * @return CartDetail
     */
    public function add(int $quantity, Product $product, $stockId = null): CartDetail
    {
        $cart = $this->cart;
        if (empty($cart->getKey())) {
            $cart->save();
        }

        /** @var CartDetail $cartDetail */
        $cartDetail = CartDetail::firstOrCreate([
            'cart_id'    => $cart->id,
            'product_id' => $product->id,
            'stock_id'   => $stockId,
        ]);

        $cartDetail->quantity = $cartDetail->quantity + $quantity;
        $cartDetail->save();

        $this->cart->details->push($cartDetail);

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
    public function content(): Collection
    {
        if ($this->count() === 0) {
            return collect([]);
        }

        $this->cart->details->each(function ($detail) {
            /** @var CartDetail $detail */
            if (blank($detail->product)) {
                return $detail->delete();
            }

            return null;
        });

        return $this->cart->details->sortBy('order');
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

    private function recalculateNormalCase()
    {
        $this->cart->details->reject($this->isDeal2x1())->each(function ($detail) {
            /** @var CartDetail $detail */
            $this->storeDetailPrice($detail);
        });

        $total = $this->cart->details->sum('total');
        $totalDolar = $this->cart->details->sum('total_dolar');

        $this->cart->subtotal = $total;
        $this->cart->subtotal_dolar = $totalDolar;
        $this->cart->total = $total;
        $this->cart->total_dolar = $totalDolar;
        $this->cart->save();
    }

    public function recalculate(): void
    {
        if (empty($this->cart)) {
            return;
        }

        if ($this->cart->details->count() === 0) {
            $this->cart->subtotal = 0;
            $this->cart->subtotal_dolar = 0;
            $this->cart->total = 0;
            $this->cart->total_dolar = 0;
            $this->cart->save();

            return;
        }

        if ($this->hasDeal2x1()) {
            $this->recalculateWithDeal2x1();

            if ($this->hasCoupon()) {
                $this->recalculateWithCoupon($this->cart->coupon);
    
                return;
            }
            
            return;
        }

        if ($this->hasCoupon()) {
            $this->recalculateWithCoupon($this->cart->coupon);

            return;
        }

        $this->recalculateNormalCase();
    }

    public function remove(string $detailHashId)
    {
        $detail = CartDetail::findByHash($detailHashId);

        if ($detail) {
            $detail->delete();
        }

        $this->recalculate();

        return true;
    }

    public function destroy()
    {
        $this->cart->details->each(function ($detail) {
            return $detail->delete();
        });

        $this->cart->delete();

        $this->cart = null;

        $this->recalculate();

        return true;
    }

    // Used for testing
    public function clean(): void
    {
        if ($this->cart->count() === 0) {
            return;
        }

        $this->cart->details->each(function ($detail) {
            $detail->delete();
        });

        $this->init();
    }

    public function getSubtotalBySessionCurrency(): float
    {
        return Session::get('BIPOLAR_CURRENCY', 'USD') === 'USD' ? $this->cart->subtotal_dolar : $this->cart->subtotal;
    }

    public function getTotalBySessionCurrency(): float
    {
        return Session::get('BIPOLAR_CURRENCY', 'USD') === 'USD' ? $this->cart->total_dolar : $this->cart->total;
    }

    /**
     * @param CartDetail $detail
     * @param float $overrideTotalPEN
     * @param float $overrideTotalUSD
     * @return CartDetail
     */
    private function storeDetailPrice(CartDetail $detail, float $overrideTotalPEN = null, float $overrideTotalUSD = null): CartDetail
    {
        if ($overrideTotalPEN !== null && $overrideTotalUSD !== null) {
            $detail->total = $overrideTotalPEN;
            $detail->total_dolar = $overrideTotalUSD;
        } else {
            $pricePEN = $detail->product->discount_pen ? $detail->product->price_pen_discount : $detail->product->price;
            $priceUSD = $detail->product->discount_usd ? $detail->product->price_usd_discount : $detail->product->price_dolar;
            $detail->total = $pricePEN * $detail->quantity;
            $detail->total_dolar = $priceUSD * $detail->quantity;
        }
        $detail->save();

        return $detail;
    }

    private function isDeal2x1()
    {
        return function ($detail) {
            /** @var CartDetail $detail */
            return $detail->product->is_deal_2x1;
        };
    }

    private function recalculateWithDeal2x1(): void
    {
        $detailsWithDeal2x1 = $this->cart->details->filter($this->isDeal2x1())->sortByDesc(function ($detail) {
            /** @var CartDetail $detail */
            return $detail->product->price;
        });
        $dettachedDetails = collect();

        $detailsWithDeal2x1->each(function ($detail) use ($dettachedDetails) {
            /** @var CartDetail $detail */
            if ($detail->quantity === 1) {
                $dettachedDetails->push($detail);

                return;
            }

            for ($detailIndex = 1; $detailIndex <= $detail->quantity; $detailIndex++) {
                $clonedDetail = $detail->replicate();
                $clonedDetail->quantity = 1;
                $clonedDetail->save();
                $dettachedDetails->push($clonedDetail);
            }

            $detail->delete();
        });

        $order = 1;
        $dettachedDetails->chunk(2)->each(function ($detailChunk) use (&$order) {
            /**
             * @var Collection $detailChunk
             * @var CartDetail $firstDetail
             * @var CartDetail $lastDetail
             */
            if ($detailChunk->count() === 1) {
                $firstDetail = $detailChunk->first();
                $firstDetail->order = $order;
                $this->storeDetailPrice($firstDetail);

                return;
            }

            $firstDetail = $detailChunk->first();
            $firstDetail->order = $order;
            $order++;
            $lastDetail = $detailChunk->last();
            $lastDetail->order = $order;
            $order++;

            $this->storeDetailPrice($firstDetail, $firstDetail->product->price, $firstDetail->product->price_dolar);
            $this->storeDetailPrice($lastDetail, 0, 0);
        });

        $this->recalculateNormalCase();
        $this->cart = $this->cart->fresh();
        $this->cart->loadMissing($this->relationships);
    }

    /**
     * @param Coupon $coupon
     * @return Cart|Model
     */
    private function recalculateWithCoupon(Coupon $coupon)
    {
        $discountPEN = 0;
        $discountUSD = 0;
        if ($coupon->type_id === config('constants.PERCENTAGE_DISCOUNT_ID')) {
            $detailsInCoupon = $this->cart->details->filter($this->detailsInCoupon($coupon));
            /* The calculate is por detail of product.*/ 
            
            $percentagePEN = $this->calculate_total_discount('PEN',$detailsInCoupon ,$coupon );
            $percentageUSD = $this->calculate_total_discount('USD',$detailsInCoupon ,$coupon );

            $discountPEN = $detailsInCoupon->sum('total') - $percentagePEN > 0 ? $percentagePEN : $detailsInCoupon->sum('total');
            $discountUSD = $detailsInCoupon->sum('total_dolar') - $percentageUSD > 0 ? $percentageUSD : $detailsInCoupon->sum('total_dolar');
       
        } elseif ($coupon->type_id === config('constants.QUANTITY_DISCOUNT_ID')) {
            $detailsInCoupon = $this->cart->details->filter($this->detailsInCoupon($coupon));
            $amountPEN = $this->calculate_total_discount('PEN',$detailsInCoupon ,$coupon );
            $amountUSD = $this->calculate_total_discount('USD',$detailsInCoupon ,$coupon );
            $discountPEN = $detailsInCoupon->sum('total') - $amountPEN;
            $discountUSD = $detailsInCoupon->sum('total_dolar') - $amountUSD;
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
     * @return Cart|Model
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
     * @return Closure
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

            // don't 2x1
            if ($detail->product->is_deal_2x1) {
                return false;
            }

            $detailInCouponProducts = in_array($detail->product_id, $coupon->products ?? []);
            $detailInCouponSubtypes = count(array_intersect($coupon->product_subtypes ?? [], $detail->product->subtypes->pluck('id')->toArray())) > 0;
            $detailInCouponTypes = count(array_intersect($coupon->product_types ?? [], $detail->product->subtypes->groupBy('type_id')->keys()->toArray())) > 0;

            return $detailInCouponProducts || $detailInCouponSubtypes || $detailInCouponTypes;
        };
    }

    public function removeCoupon()
    {
        $this->cart->coupon_id = null;
        $this->cart->save();

        return $this->recalculate();
    }

    public function hasDeal2x1(): bool
    {
        if ($this->cart->details->count() === 0) {
            return false;
        }

        $detailsWithDeal2x1 = $this->cart->details->filter(function ($detail) {
            /** @var CartDetail $detail */
            return $detail->product->is_deal_2x1;
        });

        // More than 1 because we need another product with 2x1 activated
        return $detailsWithDeal2x1->sum('quantity') > 0;
    }

    public function hasCoupon()
    {
        return !is_null($this->cart->coupon_id);
    }

    public function hasCouponExpired(): bool
    {
        if (!$this->hasCoupon()) {
            return false;
        }

        $todayBetweenCouponBeginAndEnd = now()->between($this->cart->coupon->begin, $this->cart->coupon->end);

        return !$todayBetweenCouponBeginAndEnd;
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

    private function calculate_total_discount($currency,$detailsInCoupon,$coupon){

        $records_discount = $coupon->quantityproducts;
        $total_discount=0;
        $id= 1;
        $percentage = 0;

        if( $currency === 'PEN') {
            $percentage =  $coupon->amount_pen;
        } else {
            $percentage =  $coupon->amount_usd;
        }

        if($coupon->type_id === config('constants.PERCENTAGE_DISCOUNT_ID')){
            foreach($detailsInCoupon as  $item){
                
                $subtypes_selected = $coupon->product_subtypes ?? [];

                if(!$item->product->is_deal_2x1) {

                    if($subtypes_selected == [] || 
                    count(array_intersect($coupon->product_subtypes ?? [], $item->product->subtypes->pluck('id')->toArray())) > 0) {

                        if($id <= $records_discount ) {

                            if( $currency === 'PEN'){
                                $total_discount = $total_discount + $item->total;
                            } else {
                                $total_discount = $total_discount + $item->total_dolar;
                            }

                            $id = $id + 1;

                        }
                    }
                }                

            }
        }

        if($coupon->type_id === config('constants.PERCENTAGE_DISCOUNT_ID')){ 
            $discount = $total_discount * ($percentage / 100);
        } else {
            if( $currency === 'PEN'){
                $discount = $coupon->amount_pen > 0 ? $coupon->amount_pen : 0;
            } else {
                $discount = $coupon->amount_usd > 0 ? $coupon->amount_usd : 0;
            }
        }
        

        return $discount;

    }
}