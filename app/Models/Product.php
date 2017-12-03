<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers, SoftDeletes;

    protected $table = 'products';
    protected $dates = ['deleted_at'];

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'colors_products', 'product_id', 'color_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'product_id');
    }

    public function recommendeds()
    {
        return $this->belongsToMany(Product::class, 'recommendeds', 'parent_product_id', 'recommended_product_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }

    public function subtypes()
    {
        return $this->belongsToMany(Subtype::class, 'products_subtypes', 'product_id', 'subtype_id');
    }

    public function getAdminActiveButton()
    {
        return $this->active ? "<span class='label label-pill label-success'>Activo</span>" : "<span class='label label-pill label-danger'>Inactivo</span>";
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
