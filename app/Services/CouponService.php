<?php

namespace App\Services;

use App\Models\Coupon;

class CouponService
{
    /** @var Coupon|null|object  */
    private $coupon;
    const NOT_EXIST = 1;
    const OUT_OF_DATES = 2;

    public function __construct(string $couponName)
    {
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
}