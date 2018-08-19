<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/** @mixin \Eloquent */
class Historic extends Model
{
    use Hashable, SoftDeletes;

    protected $dates = ['deleted_at'];
}
