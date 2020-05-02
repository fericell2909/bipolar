<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Services\CouponService;
use App\Instances\CartBipolar;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponController extends Controller
{
    public function add(Request $request)
    {
        $locale = \Session::get('locale');
        if (CartBipolar::getInstance()->count() === 0) {
            return $this->errorResponse(__('bipolar.coupon.empty_cart'));
        }

        $this->validate($request, ['coupon_name' => 'required|between:1,255']);

        $couponName = $request->input('coupon_name');

        $cart = CartBipolar::getInstance();

        $couponService = new CouponService($cart, $couponName, \Session::get('BIPOLAR_CURRENCY', 'PEN'));

        switch ($couponService->isValid()) {
            case $couponService::NOT_EXIST:
                return $this->errorResponse(__('bipolar.coupon.not_exists', [], $locale));
                break;
            case $couponService::OUT_OF_DATES:
                return $this->errorResponse(__('bipolar.coupon.out_of_dates', [], $locale));
                break;
            case $couponService::DOESNT_HAVE_MINIMUN:
                return $this->errorResponse(__('bipolar.coupon.doesnt_have_minimun', ['minimum' => $couponService->getMinimum()], $locale));
                break;
            case $couponService::DOESNT_HAVE_PRODUCTS_OR_TYPES_OR_SUBTYPES:
                return $this->errorResponse(__('bipolar.coupon.doesnt_has_products_or_types_or_subtypes', [], $locale));
                break;
            case $couponService::CANT_USE_FOR_FREQUENCY:
                return $this->errorResponse(__('bipolar.coupon.cant_use_for_frequency', [], $locale));
                break;
            case $couponService::USER_IS_USING_2X1:
                return $this->errorResponse(__('bipolar.coupon.user_is_using_2x1', [], $locale));
                break;
        }

        CartBipolar::getInstance()->addCoupon($couponService->getCoupon());

        return response()->json(['success' => 'Guardado con éxito']);
    }

    public function remove()
    {
        CartBipolar::getInstance()->removeCoupon();

        return response()->json(['success' => 'Guardado']);
    }

    private function errorResponse($message)
    {
        return response()->json(['message' => $message], Response::HTTP_BAD_REQUEST);
    }
}
