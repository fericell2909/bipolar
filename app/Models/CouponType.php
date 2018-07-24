<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class CouponType extends Model
{
    public $timestamps = false;

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'type_id');
    }
}
