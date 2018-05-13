<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Models\Coupon;

class CouponService
{
    /** @var Coupon|null|object  */
    private $coupon;
    private $cart;
    private $currency;
    const NOT_EXIST = 1;
    const OUT_OF_DATES = 2;
    const NOT_ALLOW_DISCOUNTED_PRODUCTS = 3;
    const DOESNT_HAVE_MINIMUN = 4;

    public function __construct(Cart $cart, string $couponName, $currentCurrency)
    {
        $this->cart = $cart;
        $this->coupon = Coupon::whereCode($couponName)->first();
        $this->currency = $currentCurrency;
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
        
        if (!$this->hasMinimunInCart()) {
            return self::DOESNT_HAVE_MINIMUN;
        }
    }

    public function getCoupon()
    {
        return $this->coupon;
    }

    public function getMinimum()
    {
        return $this->currency === 'PEN' ? "S/ {$this->coupon->minimum_pen}" : "$ {$this->coupon->minimum_usd}";
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

        return true;
    }

    private function hasMinimunInCart()
    {
        if ($this->currency === 'USD' && $this->coupon->minimum_usd) {
            return $this->cart->total_dolar >= $this->coupon->minimum_usd;
        }
        
        if ($this->currency === 'PEN' && $this->coupon->minimum_pen) {
            return $this->cart->total >= $this->coupon->minimum_pen;
        }
        
        return true;
    }
}