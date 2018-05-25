<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Type;
use App\Models\Subtype;

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
        $products = collect([]);
        $types = collect([]);
        $subtypes = collect([]);
        if ($request->filled('products')) {
            $products = Product::find(array_map(function ($element) {
                return $element["value"];
            }, $request->input('products')));
        }
        if ($request->filled('types')) {
            $types = Type::find(array_map(function ($element) {
                return $element["value"];
            }, $request->input('types')));
        }
        if ($request->filled('subtypes')) {
            $subtypes = Subtype::find(array_map(function ($element) {
                return $element["value"];
            }, $request->input('subtypes')));
        }

        $typesArray = $types->pluck('id')->toArray();
        $subtypesArray = $subtypes->pluck('id')->toArray();
        $productsArray = $products->pluck('id')->toArray();

        /** @var Coupon $coupon */
        $coupon = Coupon::findOrFail($couponId);
        $coupon->products = count($productsArray) === 0 ? null : $productsArray;
        $coupon->product_types = count($typesArray) === 0 ? null : $typesArray;
        $coupon->product_subtypes = count($subtypesArray) === 0 ? null : $subtypesArray;
        $coupon->save();

        return response()->json(['message' => 'Guardado con éxito']);
    }
}
