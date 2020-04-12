<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/** @mixin \Eloquent */
class DiscountTask extends Model
{
    use LogsActivity, Hashable;

    protected $dates = ['begin', 'end'];
    protected $casts = [
        'product_subtypes' => 'array',
        'product_types'    => 'array',
        'products'         => 'array',
    ];
    protected static $logAttributes = ['*'];
}
