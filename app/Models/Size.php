<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Size extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers;

    protected $table = 'sizes';
    public $timestamps = false;

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'size_id');
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