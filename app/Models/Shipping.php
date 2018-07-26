<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Shipping extends Model
{
    public $timestamps = false;

    public function buys()
    {
        return $this->hasMany(Buy::class, 'shipping_id');
    }

    public function includes()
    {
        return $this->hasMany(ShippingInclude::class);
    }

    public function excludes()
    {
        return $this->hasMany(ShippingExclude::class);
    }

    public function included_countries()
    {
        return $this->belongsToMany(Country::class, 'shipping_includes', 'shipping_id', 'country_id');
    }
    
    public function excluded_countries()
    {
        return $this->belongsToMany(Country::class, 'shipping_excludes', 'shipping_id', 'country_id');
    }
    
    public function included_states()
    {
        return $this->belongsToMany(CountryState::class, 'shipping_includes', 'shipping_id', 'country_state_id');
    }

    public function excluded_states()
    {
        return $this->belongsToMany(CountryState::class, 'shipping_excludes', 'shipping_id', 'country_state_id');
    }
}
