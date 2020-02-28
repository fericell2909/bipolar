<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Product extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Product $product */
        $product = $this;

        if ($this->whenLoaded('colors')) {
            $fullName = $product->getTranslation('name', 'es') . "/" . $product->getTranslation('name', 'en') . " - " . $product->colors->implode('name', ',');
        } else {
            $fullName = $product->getTranslation('name', 'es') . "/" . $product->getTranslation('name', 'en');
        }

        return [
            'id'                    => $this->when(\Auth::guard('admin')->check(), $product->id),
            'hash_id'               => $product->hash_id,
            'name'                  => (string)$product->getTranslation('name', 'es'),
            'name_english'          => (string)$product->getTranslation('name', 'en'),
            'fullname'              => $this->when(\Auth::guard('admin')->check(), (string)$fullName),
            'description'           => $product->getTranslation('description', 'es'),
            'description_english'   => $product->getTranslation('description', 'en'),
            'slug'                  => $product->slug,
            'weight'                => $product->weight,
            'price'                 => (int)$product->price,
            'price_dolar'           => (int)$product->price_dolar,
            'price_pen_discount'    => (float)$product->price_pen_discount,
            'price_usd_discount'    => (float)$product->price_usd_discount,
            'discount_pen'          => (int)$product->discount_pen,
            'discount_usd'          => (int)$product->discount_usd,
            'begin_discount'        => optional($product->begin_discount)->toDateString(),
            'end_discount'          => optional($product->end_discount)->toDateString(),
            'publish_date'          => optional($product->publish_date)->toDateTimeString(),
            'free_shipping'         => boolval($product->free_shipping),
            'is_showroom_sale'      => (bool)$product->is_showroom_sale,
            'is_salient'            => $product->is_salient,
            'preview_route'         => $this->when(\Auth::guard('admin')->check(), route('products.preview', $product->slug)),
            'edit_route'            => $this->when(\Auth::guard('admin')->check(), route('products.photos', $product->slug)),
            'shop_route'            => $this->when(\Auth::guard('admin')->check(), route('shop.product', $product->slug)),
            'photos'                => Photo::collection($this->whenLoaded('photos')),
            'subtypes'              => Subtype::collection($this->whenLoaded('subtypes')),
            'state'                 => new State($this->whenLoaded('state')),
            'label'                 => new LabelResource($this->whenLoaded('label')),
            'colors'                => Color::collection($this->whenLoaded('colors')),
            'sizes'                 => Size::collection($product->sizes_mapped()),
            'created_at_month_year' => $product->created_at->format('n-Y'),
        ];
    }
}
