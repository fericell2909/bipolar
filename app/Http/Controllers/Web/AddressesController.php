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
        $countryState = CountryState::findOrFail($request->input('country_state_billing_hidden'));
        $addressType = AddressType::whereName($addressTypeName)->firstOrFail();
        
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

        $otherAddress = Address::whereKeyNot($address->id)->whereUserId(\Auth::id())->get();

        if ($otherAddress) {
            $otherAddress->each(function ($address) {
                $address->main = false;
                $address->save();
            });
        }

        // todo: return 2nd section for the checkout form
        return redirect()->back();
    }
}
