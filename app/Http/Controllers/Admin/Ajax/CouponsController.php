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

    public function destroy($couponId)
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::findOrFail($couponId);

        $coupon->load(['buys', 'carts']);

        if ($coupon->buys->count() > 0) {
            return response()->json(['success' => false, 'message' => 'No se pueden eliminar cupones usados en compras']);
        }

        if ($coupon->carts->count() > 0) {
            \DB::table('cart_details')->whereIn('cart_id', $coupon->carts->pluck('id')->toArray())->delete();
            \DB::table('carts')->whereIn('id', $coupon->carts->pluck('id')->toArray())->delete();
        }

        try {
            $coupon->delete();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Algo fue mal']);
        }

        return response()->json(['success' => true, 'message' => 'Cupón eliminado con éxito']);
    }
}
