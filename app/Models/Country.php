<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Country extends Model
{
    public $timestamps = false;

    public function states()
    {
        return $this->hasMany(CountryState::class);
    }
}
