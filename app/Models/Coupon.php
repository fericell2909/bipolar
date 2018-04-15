<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $dates = ['begin', 'end'];

    public function type()
    {
        return $this->belongsTo(CouponType::class, 'type_id');
    }
}
