<?php

namespace App\Http\Resources;

use App\Models\Stock;
use Illuminate\Http\Resources\Json\Resource;

class Product extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Product $product */
        $product = $this;

        return [
            'id'                    => $this->when(\Auth::guard('admin')->check(), $product->id),
            'hash_id'               => $product->hash_id,
            'name'                  => (string)$product->getTranslation('name', 'es'),
            'name_english'          => (string)$product->getTranslation('name', 'en'),
            'description'           => $product->getTranslation('description', 'es'),
            'description_english'   => $product->getTranslation('description', 'en'),
            'weight'                => $product->weight,
            'discount'              => (int)$product->discount,
            'price'                 => (int)$product->price,
            'price_discount'        => (float)$product->price_discount,
            'price_dolar'           => (int)$product->price_dolar,
            'price_dolar_discount'  => (float)$product->price_dolar_discount,
            'free_shipping'         => boolval($product->free_shipping),
            'is_salient'            => $product->is_salient,
            'preview_route'         => $this->when(\Auth::guard('admin')->check(), route('products.preview', $product->slug)),
            'edit_route'            => $this->when(\Auth::guard('admin')->check(), route('products.photos', $product->slug)),
            'photos'                => Photo::collection($this->whenLoaded('photos')),
            'subtypes'              => Subtype::collection($this->whenLoaded('subtypes')),
            'state'                 => new State($this->whenLoaded('state')),
            'colors'                => Color::collection($this->whenLoaded('colors')),
            'sizes'                 => Size::collection($product->sizes()),
            'created_at_month_year' => $product->created_at->format('n-Y'),
        ];
    }
}
