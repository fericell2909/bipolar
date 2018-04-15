<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponType extends Model
{
    public $timestamps = false;

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'type_id');
    }
}
