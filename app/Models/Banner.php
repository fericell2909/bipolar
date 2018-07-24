<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Banner extends Model
{
    public $dates = ['begin_date', 'end_date'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
