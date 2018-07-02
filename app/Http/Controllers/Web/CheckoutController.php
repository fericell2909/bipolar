<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\BSale;
use App\Mail\BuyConfirmation;
use App\Models\Cart;
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

        /** @var Cart $cart */
        $cart = \CartBipolar::last();

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

        $shippingFee = null;
        //$allowShowroomPickup = false;
        $totalWeight = $cart->details->sum(function ($detail) {
            /** @var CartDetail $detail */
            return $detail->product->weight ?? 0;
        });

        if ($shippingAddresses->count() > 1) {
            $shipping = $this->getShippingByAddress($shippingAddresses->filter->main);
            $shippingFee = $this->calculateShippingByWeight($shipping, $totalWeight, \Session::get('BIPOLAR_CURRENCY'));
        } elseif ($shippingAddresses->count() === 0 && $billingAddresses->count() >= 1) {
            $shipping = $this->getShippingByAddress($billingAddresses->filter->main);
            $shippingFee = $this->calculateShippingByWeight($shipping, $totalWeight, \Session::get('BIPOLAR_CURRENCY'));
        } elseif ($shippingAddresses->count() === 0 && $billingAddresses->count() === 0) {
            $shippingFee = 0;
        }

        return view('web.shop.checkout', compact(
            'cart',
            'countries',
            'billingAddresses',
            'shippingAddresses',
            'shippingFee'
        ));
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

        $buy = new Buy;
        $buy->user()->associate(\Auth::user());
        $buy->billing_address()->associate($billingAddress);
        $buy->shipping_address()->associate($shippingAddress);
        $buy->subtotal = \CartBipolar::getSubtotalBySessionCurrency();
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
                $quantity = $cartDetail->quantity;
                $buyDetail->stock->quantity -= $quantity;
                $buyDetail->stock->save();
            }
            $buyDetail->quantity = $cartDetail->quantity;
            $buyDetail->total = \Session::get('BIPOLAR_CURRENCY', 'USD') === 'USD' ? $cartDetail->total_dolar : $cartDetail->total;
            $buyDetail->save();
        }

        \CartBipolar::destroy();

        $buy->setStatus(config('constants.BUY_INCOMPLETE_STATUS'));

        if ($request->input('showroom_pick') === 'free') {
            $buy->showroom = true;
            $buy->save();
        } elseif ($request->input('showroom_pick') === 'pay') {
            $this->shippingFeeByBuy($buy);
        }

        // The email only sends in not a production environment
        if (env('APP_ENV') !== 'production') {
            \Mail::to($request->user())->send(new BuyConfirmation($buy));
            BSale::documentCreate($buy);
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

        $shipping = $this->getShippingByAddress($buy->shipping_address);

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

        $totalShipping = $this->calculateShippingByWeight($shipping, floatval($totalWeight), \Session::get('BIPOLAR_CURRENCY'));

        $buy->shipping_fee = $totalShipping;
        $buy->total = floatval($buy->subtotal + $totalShipping);
        $buy->save();

        return $buy->shipping_fee ?? 0;
    }

    /**
     * Get a shipping address if exists from the database with the current shipping prices
     *
     * @param Address $address
     * @return Shipping|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    private function getShippingByAddress(Address $address)
    {
        return Shipping::with(['includes', 'excludes'])
            ->whereHas('includes', function ($whereIncludes) use ($address) {
                /** @var \Illuminate\Database\Query\Builder $whereIncludes */
                $whereIncludes->where('country_state_id', $address->country_state_id);
            })
            ->whereDoesntHave('excludes', function ($whereDoesntHaveExcluded) use ($address) {
                /** @var \Illuminate\Database\Query\Builder $whereDoesntHaveExcluded */
                $whereDoesntHaveExcluded->where('country_state_id', $address->country_state_id)
                    ->orWhere('country_id', $address->country_state->country_id);
            })
            ->whereActive(true)
            ->first();
    }

    /**
     * @param Shipping $shipping
     * @param float $totalWeight
     * @param string $currency
     * @return float
     */
    private function calculateShippingByWeight(Shipping $shipping, float $totalWeight, string $currency) : float
    {
        if (is_null($shipping)) {
            return floatval(0);
        }

        $isDolarCurrency = $currency === 'USD';

        switch ($totalWeight) {
            case $totalWeight <= 0.2:
                $totalShipping = ($isDolarCurrency ? $shipping->g200_dolar : $shipping->g200);
                break;
            case $totalWeight <= 0.5:
                $totalShipping = ($isDolarCurrency ? $shipping->g500_dolar : $shipping->g500);
                break;
            case $totalWeight <= 1:
                $totalShipping = ($isDolarCurrency ? $shipping->kg1_dolar : $shipping->kg1);
                break;
            case $totalWeight <= 2:
                $totalShipping = ($isDolarCurrency ? $shipping->kg2_dolar : $shipping->kg2);
                break;
            case $totalWeight <= 3:
                $totalShipping = ($isDolarCurrency ? $shipping->kg3_dolar : $shipping->kg3);
                break;
            case $totalWeight <= 4:
                $totalShipping = ($isDolarCurrency ? $shipping->kg4_dolar : $shipping->kg4);
                break;
            case $totalWeight <= 5:
                $totalShipping = ($isDolarCurrency ? $shipping->kg5_dolar : $shipping->kg5);
                break;
            case $totalWeight <= 6:
                $totalShipping = ($isDolarCurrency ? $shipping->kg6_dolar : $shipping->kg6);
                break;
            case $totalWeight <= 7:
                $totalShipping = ($isDolarCurrency ? $shipping->kg7_dolar : $shipping->kg7);
                break;
            case $totalWeight <= 8:
                $totalShipping = ($isDolarCurrency ? $shipping->kg8_dolar : $shipping->kg8);
                break;
            case $totalWeight <= 9:
                $totalShipping = ($isDolarCurrency ? $shipping->kg9_dolar : $shipping->kg9);
                break;
            case $totalWeight <= 10:
                $totalShipping = ($isDolarCurrency ? $shipping->kg10_dolar : $shipping->kg10);
                break;
            default:
                $totalShipping = 0;
                break;
        }

        return floatval($totalShipping);
    }
}
