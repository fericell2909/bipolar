<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
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

        return redirect()->route('confirmation', $buy->id);
    }

    public function confirmation($buyId)
    {
        $buy = Buy::findOrFail($buyId);

        abort_if($buy->user_id !== \Auth::id(), 403);

        return view('web.shop.confirmation', compact('buy'));
    }
}
