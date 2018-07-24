<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class ShippingExclude extends Model
{
    protected $table = 'shipping_excludes';
    public $timestamps = false;

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
