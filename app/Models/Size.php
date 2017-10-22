<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use Hashable;

    protected $table = 'sizes';
    public $timestamps = false;

    public function stocks()
    {
        return $this->hasMany(Product::class, 'size_id');
    }
}