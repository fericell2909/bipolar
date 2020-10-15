<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\Hashable;
/** @mixin \Eloquent */
class PremiumLink extends Model
{
    use LogsActivity,Hashable;

    protected $table='links';

    protected $dates = ['end'];
    protected $casts = [
        'products' => 'array',
    ];

    protected static $logAttributes = ['*'];

}