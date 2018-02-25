<?php

namespace App\Http\Controllers\Web;

use App\Mail\BuyConfirmation;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Address;
use App\Models\Buy;
use App\Models\BuyDetail;

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

    public function buy()
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
        $buy->subtotal = \CartBipolar::last()->subtotal;
        $buy->total = \CartBipolar::last()->total;
        $buy->total_dolar = \CartBipolar::last()->total_dolar;

        if (!$buy->save()) {
            return abort(500);
        }

        foreach (\CartBipolar::content() as $cartDetail) {
            $buyDetail = new BuyDetail;
            $buyDetail->buy()->associate($buy);
            $buyDetail->product()->associate($cartDetail->product);
            if ($cartDetail->stock) {
                $buyDetail->stock()->associate($cartDetail->stock);
            }
            $buyDetail->quantity = $cartDetail->quantity;
            $buyDetail->total = $cartDetail->total;
            $buyDetail->total_dolar = $cartDetail->total_dolar;
            $buyDetail->save();
        }

        \CartBipolar::destroy();

        $buy->setStatus(config('constants.BUY_INCOMPLETE_STATUS'));

        \Mail::to(\Auth::user())->send(new BuyConfirmation($buy));

        return redirect()->route('confirmation', $buy->id);
    }
}
