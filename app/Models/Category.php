<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Hashable;

class Category extends Model
{
    use Hashable;

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
