<?php

namespace App\Http\Controllers\Web\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;

class AddressesController extends Controller
{
    public function setMain($addressHashId)
    {
        $address = Address::findByHash($addressHashId);

        abort_if($address->user_id !== \Auth::id(), 403);

        $address->main = true;
        $address->save();

        $otherAddresses = Address::whereAddressTypeId($address->address_type_id)
            ->whereKeyNot($address->id)
            ->get();

        foreach ($otherAddresses as $otherAddress) {
            $otherAddress->main = false;
            $otherAddress->save();
        }

        return response()->json(['success' => true]);
    }

    public function remove($addressHashId)
    {
        $address = Address::findByHash($addressHashId);

        abort_if($address->user_id !== \Auth::id(), 403);

        $address->delete();

        return response()->json(['success' => true]);
    }
}
