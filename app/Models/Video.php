<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Video extends Model
{
    use Hashable;

    protected $table = 'videos';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
