<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Address;
use App\Models\Buy;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (\CartBipolar::count() === 0) {
            return redirect(route('shop'));
        }

        $countries = Country::orderBy('name')->get()->pluck('name', 'id')->toArray();
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
            ->where('main', true)
            ->first();
        $shippingAddress = Address::whereAddressTypeId(config('constants.ADDRESS_TYPE_SHIPPING_ID'))
            ->where('main', true)
            ->first();

        $buy = new Buy;
        $buy->user()->associate(\Auth::user());
        $buy->billing_address()->associate($billingAddress);
        $buy->shipping_address()->associate($shippingAddress);
        $buy->subtotal = \CartBipolar::last()->subtotal;
        $buy->total = \CartBipolar::last()->total;
        $buy->total_dolar = \CartBipolar::last()->total_dolar;

        if ($buy->save()) {
            \CartBipolar::destroy();
        }

        return redirect()->route('confirmation', $buy->id);
    }

    public function confirmation($buyId)
    {
        $buy = Buy::findOrFail($buyId);

        abort_if($buy->user_id !== \Auth::id(), 403);

        return view('web.shop.confirmation', compact('buy'));
    }
}
