<?php

namespace App\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FitSize extends Model
{
    use HasTranslations, GeneratesUuid;

    public $table = 'fits_sizes';
    public $timestamps = false;
    public $translatable = ['name'];
}
