<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountTask extends Model
{
    protected $dates = ['begin', 'end'];
    protected $casts = [
        'product_subtypes' => 'array',
        'product_types'    => 'array',
        'products'         => 'array',
    ];
}
