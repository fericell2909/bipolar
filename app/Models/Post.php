<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\ModelStatus\HasStatuses;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Post extends Model
{
    use HasTranslations, HasStatuses, Sluggable, SluggableScopeHelpers;

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

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'posts_tags');
    }
}
