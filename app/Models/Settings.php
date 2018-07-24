<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Settings extends Model
{
    protected $table = 'settings';
    public $timestamps = false;
}