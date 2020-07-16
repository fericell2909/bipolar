<?php

namespace App\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FitWidth extends Model
{
    use HasTranslations, GeneratesUuid;

    public $table = 'fits_widths';
    public $timestamps = false;
    public $translatable = ['name'];
}
