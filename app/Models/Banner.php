<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Spatie\Translatable\HasTranslations;

/** @mixin \Eloquent */
class Banner extends Model
{
    use HasTranslations, Hashable;

    public $dates = ['begin_date', 'end_date'];
    public $translatable = ['text'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @param Builder $query
     */
    public function scopeFromColorType($query)
    {
        return $query->whereNotNull('background_color');
    }

    /**
     * @param Builder $query
     */
    public function scopeOnlyImageType($query)
    {
        return $query->whereNull('background_color');
    }
}
