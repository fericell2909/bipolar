<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function address_type()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function country_state()
    {
        return $this->belongsTo(CountryState::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
