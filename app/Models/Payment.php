<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }
}
