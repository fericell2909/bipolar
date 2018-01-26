<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyDetail extends Model
{
    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }
}
