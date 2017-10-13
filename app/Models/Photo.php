<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';

    public function product()
    {
        return $this->belongsTo(Product::class, 'photo_id');
    }
}
