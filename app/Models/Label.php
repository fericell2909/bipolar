<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Label extends Model
{
    use Sluggable, SluggableScopeHelpers, HasTranslations, LogsActivity;

    public $translatable = ['name'];
    protected static $logAttributes = ['name', 'slug'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }
}
