<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\ModelStatus\HasStatuses;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Traits\Hashable;

/** @mixin \Eloquent */
class Post extends Model
{
    use HasTranslations, HasStatuses, Sluggable, SluggableScopeHelpers, Hashable;

    protected $translatable = ['title', 'content'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'post_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'posts_tags');
    }
}
