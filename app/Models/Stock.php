<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/** @mixin \Eloquent */
class Stock extends Model
{
    use Hashable, LogsActivity;

    protected $casts = ['bsale_stock_ids' => 'array'];
    protected $table = 'stocks';
    protected static $logAttributes = ['bsale_stock_ids', 'quantity'];

    public function buy_details()
    {
        return $this->hasMany(BuyDetail::class, 'stock_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
}
