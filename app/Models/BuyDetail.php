<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class BuyDetail extends Model
{
    public $timestamps = false;

    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function getTotalCurrencyAttribute()
    {
        if ($this->buy->currency === 'PEN') {
            return "S/ " . intval($this->total);
        } elseif ($this->buy->currency === 'USD') {
            return "$ " . intval($this->total);
        }
    }
}
