<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public function country_or_states()
    {
        return $this->hasMany(ShippingCountryState::class);
    }
}
