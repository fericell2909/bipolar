<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
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

    public function getDiscountFormatAttribute()
    {
        if ($this->type_id === config('constants.PERCENTAGE_DISCOUNT_ID')) {
            return \Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN' ? "%{$this->amount_pen}" : "%{$this->amount_usd}";
        } elseif ($this->type_id === config('constants.QUANTITY_DISCOUNT_ID')) {
            return \Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN' ? "S/{$this->amount_pen}" : "\${$this->amount_usd}";
        }
    }
}
