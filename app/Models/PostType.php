<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/** @mixin \Eloquent */
class PostType extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers, HasTranslations;

    protected $translatable = ['name'];

    public $timestamps = false;

    public function home_posts()
    {
        return $this->hasMany(HomePost::class);
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
