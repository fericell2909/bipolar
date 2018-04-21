<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function show($couponId)
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::findOrFail($couponId);

        return new CouponResource($coupon);
    }

    public function saveTypesAndSubtypes(Request $request, $couponId)
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::findOrFail($couponId);
        $coupon->product_types = $request->input('types');
        $coupon->products = $request->input('products');
        $coupon->save();

        return response()->json(['message' => 'Guardado con éxito']);
    }
}