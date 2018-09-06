<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;

/** @mixin \Eloquent */
class Buy extends Model
{
    use Hashable, HasStatuses;

    public function billing_address()
    {
        return $this->belongsTo(Address::class, 'billing_address_id')->withTrashed();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
    
    public function shipping_address()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id')->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(BuyDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSubtotalCurrencyAttribute()
    {
        $moneySign = $this->currency === 'PEN' ? 'S/' : '$';

        return "{$moneySign} " . intval($this->subtotal);
    }

    public function getTotalCurrencyAttribute()
    {
        $moneySign = $this->currency === 'PEN' ? 'S/' : '$';

        return "{$moneySign} " . intval($this->total);
    }

    public function getShippingFeeCurrencyAttribute()
    {
        $moneySign = $this->currency === 'PEN' ? 'S/' : '$';

        return "{$moneySign} " . number_format($this->shipping_fee, 2);
    }

    public function getDiscountCouponCurrencyAttribute()
    {
        $moneySign = $this->currency === 'PEN' ? 'S/' : '$';

        return "{$moneySign} " . number_format($this->discount_coupon, 2);
    }
}
