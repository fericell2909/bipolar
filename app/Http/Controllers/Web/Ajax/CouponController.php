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

        $couponIsValidResponse = $couponService->isValid();

        if ($couponIsValidResponse !== $couponService::SUCCESS) {
            return $this->errorResponse($couponService->resolveError($couponIsValidResponse, $locale));
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
