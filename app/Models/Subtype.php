<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

/** @mixin \Eloquent */
class Subtype extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers, HasTranslations, LogsActivity;

    protected $table = 'subtypes';
    public $timestamps = false;
    public $translatable = ['name'];
    protected static $logAttributes = ['name', 'slug'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_subtypes', 'subtype_id', 'product_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
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