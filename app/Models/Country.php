<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Country extends Model
{
    public function states()
    {
        return $this->hasMany(CountryState::class);
    }
}
