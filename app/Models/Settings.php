<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/** @mixin \Eloquent */
class Settings extends Model
{
    use HasTranslations;

    protected $table = 'settings';
    public $timestamps = false;
    public $translatable = ['open_hours'];
}