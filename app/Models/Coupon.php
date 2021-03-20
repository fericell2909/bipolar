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

    public function buys()
    {
        return $this->hasMany(Buy::class, 'coupon_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'coupon_id');
    }

    public function type()
    {
        return $this->belongsTo(CouponType::class, 'type_id');
    }

    public function getDiscountFormatAttribute()
    {
        if ($this->type_id === config('constants.PERCENTAGE_DISCOUNT_ID')) {
            return \Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN' ? "%" . intval($this->amount_pen) : "%" . intval($this->amount_usd);
        } elseif ($this->type_id === config('constants.QUANTITY_DISCOUNT_ID')) {
            return \Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN' ? "S/{$this->amount_pen}" : "\${$this->amount_usd}";
        }
    }

    public function getCount() {
        $records = $this->buys()->get()->filter(function ($buy) {
            return $buy->coupon_id === $this->id;
        })->count();

        return $records;
    }
}
