<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Services\ShippingService;
use App\Models\Address;

class AddressesController extends Controller
{
    public function setMain($addressHashId)
    {
        $address = Address::findByHash($addressHashId);

        abort_if($address->user_id !== \Auth::id(), 403);

        $address->main = true;
        $address->save();

        $addresses = Address::whereUserId(\Auth::id())->with('address_type', 'country_state')->get();
        $addressSameTypeIds = $addresses->filter(function ($addressSameType) use ($address) {
            /** @var Address $addressSameType */
            return $addressSameType->address_type_id === $address->address_type_id;
        })->pluck('id')->toArray();

        Address::whereIn('id', $addressSameTypeIds)->whereKeyNot($address->id)->update(['main' => false]);

        /** @var \App\Models\Cart $cart */
        $cart = \CartBipolar::last();
        list($shipping, $shippingFee) = ShippingService::calculateShippingByCart($cart, $addresses, \Session::get('BIPOLAR_CURRENCY'));

        return response()->json([
            'success'       => true,
            'shipping_fee'  => $shippingFee,
            'shipping_name' => $shipping,
        ]);
    }

    public function remove($addressHashId)
    {
        $address = Address::findByHash($addressHashId);

        abort_if($address->user_id !== \Auth::id(), 403);

        // If the deleted is a main address and there is another address of the same type
        // convert the first address found to main address
        if ($address->main) {
            /** @var Address $anotherUserAddressOfTheSameType */
            $anotherUserAddressOfTheSameType = $address->address_type->addresses()->where('user_id', \Auth::id())->get()->first();
            if ($anotherUserAddressOfTheSameType) {
                $anotherUserAddressOfTheSameType->main = true;
                $anotherUserAddressOfTheSameType->save();
            }
        }

        try {
            $address->delete();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'No se pudo eliminar']);
        }

        return response()->json(['success' => true]);
    }
}
