<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Models\Coupon;

class CouponService
{
    /** @var Coupon|null|object  */
    private $coupon;
    private $cart;
    const NOT_EXIST = 1;
    const OUT_OF_DATES = 2;
    const NOT_ALLOW_DISCOUNTED_PRODUCTS = 3;

    public function __construct(Cart $cart, string $couponName)
    {
        $this->cart = $cart;
        $this->coupon = Coupon::whereCode($couponName)->first();
    }

    public function isValid()
    {
        if ($this->doesntExist()) {
            return self::NOT_EXIST;
        }

        if (!$this->isBetweenDates()) {
            return self::OUT_OF_DATES;
        }

        if (!$this->allowDiscountedProducts()) {
            return self::NOT_ALLOW_DISCOUNTED_PRODUCTS;
        }
    }

    public function getCoupon()
    {
        return $this->coupon;
    }

    private function doesntExist()
    {
        return is_null($this->coupon);
    }

    private function isBetweenDates()
    {
        return now()->greaterThanOrEqualTo($this->coupon->begin) && now()->lessThanOrEqualTo($this->coupon->end);
    }

    private function allowDiscountedProducts()
    {
        $hasDiscountedProducts = $this->cart->details->contains(function ($detail) {
            /** @var \App\Models\CartDetail $detail */
            return !is_null($detail->product->discount_usd) && !is_null($detail->product->discount_pen);
        });

        if (!$hasDiscountedProducts) {
            return true;
        } else if ($this->coupon->discounted_products && $hasDiscountedProducts) {
            return true;
        } elseif (!boolval($this->coupon->discounted_products) && $hasDiscountedProducts) {
            return false;
        }
    }
}