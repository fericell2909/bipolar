<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Hashable;

class Tag extends Model
{
    use Hashable;

    public $timestamps = false;

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
