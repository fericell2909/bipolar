<?php

namespace App\Http\Controllers\Web;

use App\Events\SaleSuccessful;
use App\Http\Controllers\Controller;
use App\Http\Services\CouponService;
use App\Http\Services\ShippingService;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Country;
use App\Models\Address;
use App\Models\Buy;
use App\Models\BuyDetail;
use App\Models\Shipping;
use Illuminate\Http\Request;
use App\Instances\CartBipolar;
use Illuminate\Http\Response;
use Jenssegers\Agent\Agent;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        if (CartBipolar::getInstance()->count() === 0) {
            return redirect(route('shop'));
        }

        /** @var Cart $cart */
        $cart = CartBipolar::getInstance()->model();

        if ($request->filled('promo')) {
            $couponService = new CouponService($cart, $request->input('promo'), \Session::get('BIPOLAR_CURRENCY', 'PEN'));

            $couponIsValidResponse = $couponService->isValid();

            if ($couponIsValidResponse !== $couponService::SUCCESS) {
                return flash()->error($couponService->resolveError($couponIsValidResponse, \Session::get('locale')));
            }
        }

        $countries = Country::orderBy('name')->get()->mapWithKeys(function ($country) {
            return [$country->id => mb_strtoupper($country->name)];
        })->toArray();
        $addresses = Address::whereUserId(\Auth::id())->with('address_type', 'country_state')->get();

        $billingAddresses = $addresses->filter(function ($address) {
            return $address->address_type->name == 'billing';
        });
        $shippingAddresses = $addresses->filter(function ($address) {
            return $address->address_type->name == 'shipping';
        });

        list($shipping, $shippingFee, $hasShowroomPickup, $isDniRequired) = ShippingService::calculateShippingByCart($cart, $addresses, \Session::get('BIPOLAR_CURRENCY'));

        return view('web.shop.checkout', [
            'cart'              => $cart,
            'countries'         => $countries,
            'billingAddresses'  => $billingAddresses,
            'shippingAddresses' => $shippingAddresses,
            'shippingName'      => $shipping,
            'shippingFee'       => $shippingFee,
            'hasShowroomPickup' => $hasShowroomPickup,
            'isDniRequired'     => $isDniRequired,
        ]);
    }

    public function buy(Request $request)
    {
        $cart = CartBipolar::getInstance();

        if ($cart->count() === 0) {
            return redirect()->back();
        }

        if ($cart->hasCouponExpired()) {
            $cart->removeCoupon();
            flash(__('bipolar.checkout.coupon_not_found'), 'danger');

            return back();
        }

        $billingAddress = Address::whereAddressTypeId(config('constants.ADDRESS_TYPE_BILLING_ID'))
            ->where('user_id', \Auth::id())
            ->where('main', true)
            ->first();

        if (is_null($billingAddress)) {
            flash()->error('No hay una dirección de pago registrada');

            return redirect()->back();
        }

        $shippingAddress = Address::whereAddressTypeId(config('constants.ADDRESS_TYPE_SHIPPING_ID'))
            ->where('user_id', \Auth::id())
            ->where('main', true)
            ->first();

        if (is_null($shippingAddress)) {
            /** @var Address $shippingAddress */
            $shippingAddress = $billingAddress->replicate();
            $shippingAddress->user_id = \Auth::id();
            $shippingAddress->address_type_id = config('constants.ADDRESS_TYPE_SHIPPING_ID');
            $shippingAddress->push();
        }

        $buy = new Buy;
        $buy->user()->associate(\Auth::user());
        $buy->billing_address()->associate($billingAddress);
        $buy->shipping_address()->associate($shippingAddress);
        $buy->subtotal = $cart->getSubtotalBySessionCurrency();
        $buy->total = $cart->getTotalBySessionCurrency();
        $buy->currency = $request->session()->get('BIPOLAR_CURRENCY', 'USD');

        $agent = new Agent();

        $buy->metadata = collect([
            'platform' => $agent->platform() ?? '--',
            'browser'  => $agent->browser() ?? '--',
            'device'   => $agent->device() ?? '--',
        ])->toJson();

        if ($cart->hasCoupon()) {
            $buy->coupon()->associate($cart->getCoupon());
            $buy->discount_coupon = $cart->getCouponDiscountByCurrency($request->session()->get('BIPOLAR_CURRENCY', 'USD'));
        }

        abort_if(!$buy->save(), Response::HTTP_INTERNAL_SERVER_ERROR);

        $cartContent = $cart->content();
        foreach ($cartContent as $cartDetail) {
            /** @var CartDetail $cartDetail */
            $buyDetail = new BuyDetail;
            $buyDetail->buy()->associate($buy);
            $buyDetail->product()->associate($cartDetail->product);
            if ($cartDetail->stock) {
                $buyDetail->stock()->associate($cartDetail->stock);
                $buyDetail->stock->save();
            }
            $buyDetail->quantity = $cartDetail->quantity;
            $buyDetail->total = $request->session()->get('BIPOLAR_CURRENCY', 'USD') === 'USD' ? $cartDetail->total_dolar : $cartDetail->total;
            $buyDetail->save();
        }

        $cart->destroy();

        $buy->setStatus(config('constants.BUY_INCOMPLETE_STATUS'));

        if ($request->input('showroom_pick') === 'free') {
            $buy->showroom = true;
            $buy->shipping_id = config('constants.SHIPPING_SHOWROOM_PICKUP_ID');
            $buy->save();
        } elseif ($request->input('showroom_pick') === 'pay') {
            $this->shippingFeeByBuy($buy);
        }

        if ($request->filled('dni_hidden')) {
            $user = \Auth::user();
            $user->dni = $request->input('dni_hidden');
            $user->save();
        }

        // The email only sends in a non production environment
        if (config('app.env') !== 'production') {
            event(new SaleSuccessful($buy));
        }

        return redirect()->route('confirmation', $buy->id);
    }

    /**
     * Return total for shipping
     *
     * @param Buy $buy
     * @return float
     */
    private function shippingFeeByBuy(Buy $buy): float
    {
        if ($buy->showroom) {
            return 0;
        }

        $shipping = ShippingService::getShippingByAddress($buy->shipping_address);

        if (is_null($shipping)) {
            $shipping = Shipping::with(['includes', 'excludes'])
                ->whereHas('includes', function ($whereIncludes) use ($buy) {
                    /** @var \Illuminate\Database\Query\Builder $whereIncludes */
                    $whereIncludes->where('country_state_id', $buy->shipping_address->country_state_id)
                        ->orWhere('country_id', $buy->shipping_address->country_state->country_id);
                })
                ->whereDoesntHave('excludes', function ($whereDoesntHaveExcluded) use ($buy) {
                    /** @var \Illuminate\Database\Query\Builder $whereDoesntHaveExcluded */
                    $whereDoesntHaveExcluded->where('country_state_id', $buy->shipping_address->country_state_id)
                        ->orWhere('country_id', $buy->shipping_address->country_state->country_id);
                })
                ->whereActive(true)
                ->first();
        }

        if (is_null($shipping)) {
            return 0;
        }

        $totalWeight = $buy->details
            ->reject(function ($detail) {
                /** @var BuyDetail $detail */
                return boolval($detail->product->free_shipping);
            })
            ->sum(function ($detail) {
                /** @var BuyDetail $detail */
                return $detail->product->weight ?? 0;
            });

        $totalShipping = ShippingService::calculateShippingByWeight($shipping, floatval($totalWeight), \Session::get('BIPOLAR_CURRENCY'));

        $buy->shipping_fee = $totalShipping;
        $buy->total = floatval($buy->total + $totalShipping);
        $buy->shipping()->associate($shipping);
        $buy->save();

        return $buy->shipping_fee ?? 0;
    }
}
