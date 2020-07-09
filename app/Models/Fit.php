<?php

namespace App\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Fit extends Model
{
    use HasTranslations, GeneratesUuid;

    public $timestamps = false;
    public $translatable = ['name'];
}
