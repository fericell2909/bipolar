<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['session_id'];

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
}
