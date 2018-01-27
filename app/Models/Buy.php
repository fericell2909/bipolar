<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    public function billing_address()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }
    
    public function shipping_address()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function details()
    {
        return $this->hasMany(BuyDetail::class);
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
}
