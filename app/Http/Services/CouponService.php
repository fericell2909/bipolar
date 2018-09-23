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
    const DOESNT_HAVE_MINIMUN = 4;
    const DOESNT_HAVE_PRODUCTS_OR_TYPES_OR_SUBTYPES = 5;
    const CANT_USE_FOR_FREQUENCY = 6;
    const SUCCESS = 99;

    public function __construct(Cart $cart, string $couponName, $currentCurrency)
    {
        $this->cart = $cart;
        $this->coupon = Coupon::whereCode($couponName)->first();
        $this->currency = $currentCurrency;
    }

    public function isValid() : int
    {
        if ($this->doesntExist()) {
            return self::NOT_EXIST;
        }

        if (!$this->isBetweenDates()) {
            return self::OUT_OF_DATES;
        }

        if (!$this->hasMinimunInCart()) {
            return self::DOESNT_HAVE_MINIMUN;
        }

        if ($this->doesntHaveProductsTypesOrSubtypes()) {
            return self::DOESNT_HAVE_PRODUCTS_OR_TYPES_OR_SUBTYPES;
        }

        if ($this->cantUseForFrequency()) {
            return self::CANT_USE_FOR_FREQUENCY;
        }

        return self::SUCCESS;
    }

    public function getCoupon()
    {
        return $this->coupon;
    }

    public function getMinimum()
    {
        return $this->currency === 'PEN' ? "S/ {$this->coupon->minimum_pen}" : "$ {$this->coupon->minimum_usd}";
    }

    private function doesntExist() : bool
    {
        return is_null($this->coupon);
    }

    private function isBetweenDates() : bool
    {
        return now()->greaterThanOrEqualTo($this->coupon->begin) && now()->lessThanOrEqualTo($this->coupon->end);
    }

    private function hasMinimunInCart() : bool
    {
        if ($this->currency === 'USD' && $this->coupon->minimum_usd) {
            return $this->cart->total_dolar >= $this->coupon->minimum_usd;
        }
        
        if ($this->currency === 'PEN' && $this->coupon->minimum_pen) {
            return $this->cart->total >= $this->coupon->minimum_pen;
        }
        
        return true;
    }

    private function doesntHaveProductsTypesOrSubtypes() : bool
    {
        $hasTypes = false;
        $hasSubtypes = false;
        $hasProducts = false;
        $productTypes = $this->coupon->product_types;
        $productSubtypes = $this->coupon->product_subtypes;
        $products = $this->coupon->products;

        if ($productTypes) {
            $hasTypes = $this->cart->details->contains(function ($detail) use ($productTypes) {
                /** @var \App\Models\CartDetail $detail */
                return $detail->product->subtypes->contains(function ($subtype) use ($productTypes) {
                    /** @var \App\Models\Subtype $subtype */
                    return in_array($subtype->type_id, $productTypes);
                });
            });
        }

        if ($productSubtypes) {
            $hasSubtypes = $this->cart->details->contains(function ($detail) use ($productSubtypes) {
                /** @var \App\Models\CartDetail $detail */
                return $detail->product->subtypes->contains(function ($subtype) use ($productSubtypes) {
                    /** @var \App\Models\Subtype $subtype */
                    return in_array($subtype->id, $productSubtypes);
                });
            });
        }

        if ($products) {
            $hasProducts = $this->cart->details->contains(function ($detail) use ($products) {
                /** @var \App\Models\CartDetail $detail */
                return in_array($detail->product_id, $products);
            });
        }

        return !($hasTypes || $hasSubtypes || $hasProducts);
    }

    private function cantUseForFrequency()
    {
        // 0 = unlimited
        if ($this->coupon->frequency === 0) {
            return false;
        }

        $usedCoupons = $this->cart->user->buys->filter(function ($buy) {
            /** @var \App\Models\Buy $buy */
            return $buy->coupon_id === $this->coupon->id;
        })->count();

        return $usedCoupons >= $this->coupon->frequency;
    }
}