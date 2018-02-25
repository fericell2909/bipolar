<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;

class Buy extends Model
{
    use Hashable, HasStatuses;

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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSubtotalCurrencyAttribute()
    {
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return "S/ " . intval($this->subtotal);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return "$ " . intval($this->subtotal);
        }
    }

    public function getSubtotalSessionAttribute()
    {
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return intval($this->total);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return intval($this->total_dolar);
        }
    }

    public function getTotalCurrencyAttribute()
    {
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return "S/ " . intval($this->total);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return "$ " . intval($this->total_dolar);
        }
    }

    public function getTotalSessionAttribute()
    {
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return intval($this->total);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return intval($this->total_dolar);
        }
    }
}
