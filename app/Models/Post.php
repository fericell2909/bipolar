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

    public function photos()
    {
        return $this->hasMany(Photo::class, 'post_id');
    }
}
