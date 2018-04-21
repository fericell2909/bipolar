<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $dates = ['begin', 'end'];
    protected $casts = [
        'product_subtypes' => 'array',
        'product_types'    => 'array',
        'products'         => 'array',
    ];

    public function type()
    {
        return $this->belongsTo(CouponType::class, 'type_id');
    }
}
