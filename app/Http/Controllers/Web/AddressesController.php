<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AddressType;
use App\Http\Requests\Web\AddressNewRequest;
use App\Models\CountryState;
use App\Models\Address;

class AddressesController extends Controller
{
    public function add(AddressNewRequest $request, $addressTypeName)
    {
        $countryState = null;
        $redirectToSecondPart = false;
        $redirectToThirdPart = false;
        if ($request->filled('country_state_billing_hidden')) {
            $countryState = CountryState::findOrFail($request->input('country_state_billing_hidden'));
            $redirectToSecondPart = true;
        } elseif ($request->filled('country_state_shipping_hidden')) {
            $countryState = CountryState::findOrFail($request->input('country_state_shipping_hidden'));
            $redirectToThirdPart = true;
        }
        $addressType = AddressType::whereName($addressTypeName)->firstOrFail();
        
        abort_if(is_null($countryState), 404);

        $address = new Address;
        $address->country_state()->associate($countryState);
        $address->address_type()->associate($addressType);
        $address->user()->associate(\Auth::user());
        $address->name = $request->input('name');
        $address->lastname = $request->input('lastname');
        $address->email = $request->input('email');
        $address->phone = $request->input('phone');
        $address->address = $request->input('address');
        $address->zip = $request->input('zip');
        $address->main = true;
        $address->save();

        $otherAddress = Address::whereKeyNot($address->id)
            ->whereAddressTypeId($addressType->id)
            ->whereUserId(\Auth::id())
            ->get();

        if ($otherAddress) {
            $otherAddress->each(function ($address) {
                $address->main = false;
                $address->save();
            });
        }

        $query = [];
        if ($redirectToSecondPart) {
            $query['part'] = 2;
        } elseif ($redirectToThirdPart) {
            $query['part'] = 3;
        }

        return redirect()->route('checkout', $query);
    }
}
