<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Hashable;
use Illuminate\Database\Eloquent\SoftDeletes;

/** @mixin \Eloquent */
class Address extends Model
{
    use Hashable, SoftDeletes;

    protected $dates = ['deleted_at'];

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
