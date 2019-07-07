<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Stock extends Model
{
    use Hashable;
    protected $casts = [
        'bsale_stock_ids' => 'array',
    ];

    protected $table = 'stocks';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
}
