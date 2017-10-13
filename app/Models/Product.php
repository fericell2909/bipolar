<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers;

    protected $table = 'products';
    protected $dates = ['deleted_at'];

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'colors_products', 'product_id', 'color_id');
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
