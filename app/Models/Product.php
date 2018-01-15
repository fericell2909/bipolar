<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers, SoftDeletes, HasTranslations;

    protected $table = 'products';
    protected $dates = ['deleted_at'];
    protected $translatable = ['name', 'description'];

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

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
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

    /**
     * Pseudo Relationship
     * This function get all the sizes finded in stocks, always return a collection
     * @return Collection
     */
    public function sizes() : Collection
    {
        $sizes = $this->stocks->filter(function ($stock) {
            return $stock->size !== null;
        })->map(function ($stock) {
            /** @var Stock $stock */
            return $stock->size;
        })->uniqueStrict();

        return $sizes;
    }

    public function getPriceCurrencyAttribute()
    {
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return "S/ " . intval($this->price);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return "$ " . intval($this->price_dolar);
        }
    }
}
