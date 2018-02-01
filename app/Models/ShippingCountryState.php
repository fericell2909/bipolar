<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCountryState extends Model
{
    protected $table = 'shipping_country_states';

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function country_state()
    {
        return $this->belongsTo(CountryState::class);
    }
}
