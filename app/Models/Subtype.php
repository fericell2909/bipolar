<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/** @mixin \Eloquent */
class Subtype extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers, HasTranslations;

    protected $table = 'subtypes';
    public $timestamps = false;
    public $translatable = ['name'];

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