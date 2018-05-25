<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['session_id', 'user_id'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function details()
    {
        return $this->hasMany(CartDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalCurrencyAttribute()
    {
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return "S/ " . intval($this->total);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return "$ " . intval($this->total_dolar);
        }
    }

    public function getTotalDiscountCouponAttribute()
    {
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return "S/ " . intval($this->discount_coupon_pen);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return "$ " . intval($this->discount_coupon_usd);
        }
    }

    public function destroyCart()
    {
        if ($this->details->count() === 0) {
            return false;
        }

        $this->details->each(function ($detail) {
            /** @var CartDetail $detail */
            $detail->delete();
        });

        \DB::table('carts')->delete($this->id);

        return true;
    }
}
