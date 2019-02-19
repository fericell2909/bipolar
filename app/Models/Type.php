<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

/** @mixin \Eloquent */
class Type extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers, HasTranslations, LogsActivity;

    protected $table = 'types';
    public $timestamps = false;
    public $translatable = ['name'];
    protected static $logAttributes = ['name', 'slug', 'order'];

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