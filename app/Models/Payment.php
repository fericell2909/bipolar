<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Payment extends Model
{
    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }
}
