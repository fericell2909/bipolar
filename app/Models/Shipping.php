<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false;

    public function includes()
    {
        return $this->hasMany(ShippingInclude::class);
    }

    public function excludes()
    {
        return $this->hasMany(ShippingExclude::class);
    }
}
