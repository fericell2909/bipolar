<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use Hashable;

    protected $table = 'photos';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
