<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use Hashable;

    protected $table = 'colors';
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'colors_products', 'color_id', 'product_id');
    }
}
