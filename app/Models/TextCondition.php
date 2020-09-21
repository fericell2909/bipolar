<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;
use App\Traits\Hashable;
/** @mixin \Eloquent */
class TextCondition extends Model
{
    use LogsActivity,Hashable,  HasTranslations;

    protected $table='products_conditions_text';
    protected $translatable = ['name', 'description'];

    protected $casts = [
        'products'         => 'array',
    ];
    
    protected static $logAttributes = ['*'];

}
