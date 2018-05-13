<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Services\CouponService;
use App\Models\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponController extends Controller
{
    public function add(Request $request)
    {
        if (\CartBipolar::count() === 0) {
            return $this->errorResponse("No hay elementos en el carrito");
        }

        $this->validate($request, ['coupon_name' => 'required|between:1,255']);

        $couponName = $request->input('coupon_name');

        /** @var Cart $cart */
        $cart = \CartBipolar::last();

        $couponService = new CouponService($cart, $couponName);

        switch ($couponService->isValid()) {
            case $couponService::NOT_EXIST:
                return $this->errorResponse("El cupón no existe");
                break;
            case $couponService::OUT_OF_DATES:
                return $this->errorResponse("El cupón se encuentra fuera del rango de fechas");
                break;
            case $couponService::NOT_ALLOW_DISCOUNTED_PRODUCTS:
                return $this->errorResponse("Este cupón no permite que haya productos con descuento");
                break;
        }

        \CartBipolar::addCoupon($couponService->getCoupon());

        return response()->json(['success' => 'Guardado con éxito']);
    }

    public function remove()
    {
        \CartBipolar::removeCoupon();

        return response()->json(['success' => 'Guardado']);
    }

    private function errorResponse($message)
    {
        return response()->json(['message' => $message], Response::HTTP_BAD_REQUEST);
    }
}
