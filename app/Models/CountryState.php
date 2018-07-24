<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class CountryState extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
