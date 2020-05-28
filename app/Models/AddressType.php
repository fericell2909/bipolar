<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class AddressType extends Model
{
    protected $table = 'address_types';
    public $timestamps = false;

    public function addresses()
    {
        return $this->hasMany(Address::class, 'address_type_id');
    }
}
