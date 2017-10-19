<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers;

    protected $table = 'types';
    public $timestamps = false;

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