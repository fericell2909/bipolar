<?php

namespace App\Http\Controllers\Web\Ajax;

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
