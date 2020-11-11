<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\Hashable;
use Spatie\Translatable\HasTranslations;
/** @mixin \Eloquent */
class PremiumLink extends Model
{
    use LogsActivity,Hashable,HasTranslations;

    protected $table='links';

    protected $dates = ['end'];
    protected $casts = [
        'products' => 'array',
    ];

    protected $translatable = ['name', 'description'];

    protected static $logAttributes = ['*'];

}