<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function details()
    {
        return $this->hasMany(CartDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
