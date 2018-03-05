<?php

namespace App\Http\Controllers\Web;

use App\Mail\BuyConfirmation;
use App\Http\Controllers\Controller;
use App\Models\CartDetail;
use App\Models\Country;
use App\Models\Address;
use App\Models\Buy;
use App\Models\BuyDetail;
use App\Models\Shipping;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (\CartBipolar::count() === 0) {
            return redirect(route('shop'));
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

        return view('web.shop.checkout', compact('countries', 'billingAddresses', 'shippingAddresses'));
    }

    public function buy(Request $request)
    {
        if (\CartBipolar::count() === 0) {
            return redirect()->back();
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

        $lastCart = \CartBipolar::last();

        $buy = new Buy;
        $buy->user()->associate(\Auth::user());
        $buy->billing_address()->associate($billingAddress);
        $buy->shipping_address()->associate($shippingAddress);
        $buy->subtotal = $lastCart->subtotal;
        $buy->total = \CartBipolar::getTotalBySessionCurrency();
        $buy->currency = \Session::get('BIPOLAR_CURRENCY', 'USD');

        abort_if(!$buy->save(), 500);

        foreach (\CartBipolar::content() as $cartDetail) {
            /** @var CartDetail $cartDetail */
            $buyDetail = new BuyDetail;
            $buyDetail->buy()->associate($buy);
            $buyDetail->product()->associate($cartDetail->product);
            if ($cartDetail->stock) {
                $buyDetail->stock()->associate($cartDetail->stock);
            }
            $buyDetail->quantity = $cartDetail->quantity;
            $buyDetail->total = \Session::get('BIPOLAR_CURRENCY', 'USD') === 'USD' ? $cartDetail->total_dolar : $cartDetail->total;
            $buyDetail->save();
        }

        \CartBipolar::destroy();

        $buy->setStatus(config('constants.BUY_INCOMPLETE_STATUS'));

        if ($request->filled('showroom_pick')) {
            $buy->showroom = true;
            $buy->save();
        } else {
            $this->calculateShippingFee($buy);
        }

        \Mail::to(\Auth::user())->send(new BuyConfirmation($buy));

        return redirect()->route('confirmation', $buy->id);
    }

    /**
     * Return total for shipping
     *
     * @param Buy $buy
     * @return float
     */
    private function calculateShippingFee(Buy $buy) : float
    {
        if ($buy->showroom) {
            return 0;
        }

        $shipping = Shipping::with(['includes', 'excludes'])
            ->whereHas('includes', function ($whereIncludes) use ($buy) {
                /** @var \Illuminate\Database\Query\Builder $whereIncludes */
                $whereIncludes->where('country_state_id', $buy->shipping_address->country_state_id);
            })
            ->whereDoesntHave('excludes', function ($whereDoesntHaveExcluded) use ($buy) {
                /** @var \Illuminate\Database\Query\Builder $whereDoesntHaveExcluded */
                $whereDoesntHaveExcluded->where('country_state_id', $buy->shipping_address->country_state_id)
                    ->orWhere('country_id', $buy->shipping_address->country_state->country_id);
            })
            ->whereActive(true)
            ->first();

        if (is_null($shipping)) {
            $shipping = Shipping::with(['includes', 'excludes'])
                ->whereHas('includes', function ($whereIncludes) use ($buy) {
                    /** @var \Illuminate\Database\Query\Builder $whereIncludes */
                    $whereIncludes->where('country_id', $buy->shipping_address->country_state->country_id);
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

        $totalWeight = $buy->details->sum(function ($detail) {
            /** @var BuyDetail $detail */
            return $detail->product->weight ?? 0;
        });

        $dolarsPrice = \Session::get('BIPOLAR_CURRENCY') === 'USD';

        switch ($totalWeight) {
            case $totalWeight <= 0.2: $totalShipping = ($dolarsPrice ? $shipping->g200_dolar : $shipping->g200); break;
            case $totalWeight <= 0.5: $totalShipping = ($dolarsPrice ? $shipping->g500_dolar : $shipping->g500); break;
            case $totalWeight <= 1: $totalShipping = ($dolarsPrice ? $shipping->kg1_dolar : $shipping->kg1); break;
            case $totalWeight <= 2: $totalShipping = ($dolarsPrice ? $shipping->kg2_dolar : $shipping->kg2); break;
            case $totalWeight <= 3: $totalShipping = ($dolarsPrice ? $shipping->kg3_dolar : $shipping->kg3); break;
            case $totalWeight <= 4: $totalShipping = ($dolarsPrice ? $shipping->kg4_dolar : $shipping->kg4); break;
            case $totalWeight <= 5: $totalShipping = ($dolarsPrice ? $shipping->kg5_dolar : $shipping->kg5); break;
            case $totalWeight <= 6: $totalShipping = ($dolarsPrice ? $shipping->kg6_dolar : $shipping->kg6); break;
            case $totalWeight <= 7: $totalShipping = ($dolarsPrice ? $shipping->kg7_dolar : $shipping->kg7); break;
            case $totalWeight <= 8: $totalShipping = ($dolarsPrice ? $shipping->kg8_dolar : $shipping->kg8); break;
            case $totalWeight <= 9: $totalShipping = ($dolarsPrice ? $shipping->kg9_dolar : $shipping->kg9); break;
            case $totalWeight <= 10: $totalShipping = ($dolarsPrice ? $shipping->kg10_dolar : $shipping->kg10); break;
            default: $totalShipping = 0; break;
        }

        $buy->shipping_fee = $totalShipping;
        $buy->total = floatval($buy->subtotal + $totalShipping);
        $buy->save();

        return $buy->shipping_fee;
    }
}
