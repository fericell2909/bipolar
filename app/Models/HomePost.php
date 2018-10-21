<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class HomePost extends Model
{
    protected $dates = ['begin_date'];

    use Hashable, Sluggable, SluggableScopeHelpers;

    protected $table = 'home_posts';

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function post_type()
    {
        return $this->belongsTo(PostType::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }
}
