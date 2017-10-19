<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;

class Subtype extends Model
{
    use Hashable;

    protected $table = 'subtypes';
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_subtypes', 'subtype_id', 'product_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}