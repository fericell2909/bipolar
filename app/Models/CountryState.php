<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryState extends Model
{
    public function country()
    {
        return $this->belongsTo(CountryState::class);
    }
}
