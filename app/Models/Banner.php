<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/** @mixin \Eloquent */
class Banner extends Model
{
    use HasTranslations;

    public $dates = ['begin_date', 'end_date'];
    public $translatable = ['text'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
