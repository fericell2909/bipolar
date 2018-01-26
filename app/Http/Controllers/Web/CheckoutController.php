<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Address;

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
    }
}
