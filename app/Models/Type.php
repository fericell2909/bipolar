<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Type extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers, HasTranslations;

    protected $table = 'types';
    public $timestamps = false;
    public $translatable = ['name'];

    public function subtypes()
    {
        return $this->hasMany(Subtype::class, 'type_id');
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