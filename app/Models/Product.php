<?php

namespace App\Models;

use App\Traits\Hashable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;
use App\Models\Video;

/** @mixin \Eloquent */
class Product extends Model
{
    use Hashable, Sluggable, SluggableScopeHelpers, SoftDeletes, HasTranslations, LogsActivity, GeneratesUuid;

    protected $table = 'products';
    protected $dates = ['deleted_at', 'begin_discount', 'end_discount', 'publish_date'];
    protected $translatable = ['name', 'description'];
    protected $fillable = [
        'begin_discount',
        'end_discount',
        'discount_pen',
        'discount_usd',
        'price_pen_discount',
        'price_usd_discount',
        'publish_date',
        'is_deal_2x1',
    ];
    protected static $logAttributes = ['state_id'];

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'colors_products', 'product_id', 'color_id');
    }

    public function fit_size()
    {
        return $this->belongsTo(FitSize::class);
    }

    public function fit_width()
    {
        return $this->belongsTo(FitWidth::class);
    }

    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'product_id');
    }

    public function recommended_by()
    {
        return $this->belongsToMany(Product::class, 'recommendeds', 'recommended_product_id', 'parent_product_id');
    }

    public function recommendations()
    {
        return $this->belongsToMany(Product::class, 'recommendeds', 'parent_product_id', 'recommended_product_id');
    }

    public function sizes_active()
    {
        return $this->belongsToMany(Size::class, 'stocks', 'product_id', 'size_id')->wherePivot('quantity', '>', 0)->as('stocks_pivot');
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

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * Pseudo Relationship
     * This function get all the sizes finded in stocks, always return a collection
     * @return Collection
     */
    public function sizes_mapped(): Collection
    {
        $sizes = $this->stocks->filter(function ($stock) {
            return $stock->size !== null;
        })->map(function ($stock) {
            /** @var Stock $stock */
            return $stock->size;
        })->uniqueStrict();

        return $sizes;
    }

    public function hasOwnDiscount()
    {
        return (!is_null($this->discount_pen) && !is_null($this->discount_usd));
    }

    public function mainPhoto()
    {
        $this->loadMissing('photos');

        return $this->photos->sortBy(function ($photo) {
            /** @var Photo $photo */
            return $photo->order;
        })->first();
    }

    public function getPriceCurrencyAttribute()
    {
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return "S/ " . intval($this->price);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return "$ " . intval($this->price_dolar);
        }
    }

    public function getDiscountAmountAttribute()
    {
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return intval($this->discount_pen);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return intval($this->discount_usd);
        }
    }

    public function getPriceDiscountCurrencyAttribute()
    {
        if (\Session::get('BIPOLAR_CURRENCY', 'PEN') === 'PEN') {
            return "S/ " . intval($this->price_pen_discount);
        } elseif (\Session::get('BIPOLAR_CURRENCY') === 'USD') {
            return "$ " . intval($this->price_usd_discount);
        }
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'product_id');
    }
}
