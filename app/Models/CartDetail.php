<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class CartDetail extends Model
{
    use Hashable;

    protected $fillable = ['cart_id', 'product_id', 'stock_id'];
    protected $casts = [
        'total'       => 'float',
        'total_dolar' => 'float',
    ];
    public $timestamps = false;

    public function cart()
    {
        return $this->belongsTo(Cart::class);
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
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return "S/ " . intval($this->total);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return "$ " . intval($this->total_dolar);
        }
    }
}
