<?php

namespace App\Models;

use App\Traits\Hashable;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/** @mixin \Eloquent */
class Color extends Model
{
    use Hashable, GeneratesUuid, HasTranslations;

    protected $table = 'colors';
    public $timestamps = false;
    public $translatable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'colors_products', 'color_id', 'product_id');
    }
}
