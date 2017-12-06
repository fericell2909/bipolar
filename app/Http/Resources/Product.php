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
        /** @var \App\Models\Product|Resource $this */
        return [
            'id'          => $this->when(\Auth::guard('admin')->check(), $this->id),
            'hash_id'     => $this->hash_id,
            'name'        => $this->name,
            'description' => $this->description,
            'weight'      => $this->weight,
            'price'       => $this->price,
            'is_salient'  => $this->is_salient,
            'edit_route'  => route('products.photos', $this->slug),
            'photos'      => Photo::collection($this->whenLoaded('photos')),
            'subtypes'    => Subtype::collection($this->whenLoaded('subtypes')),
            'state'       => new State($this->whenLoaded('state')),
            'colors'      => Color::collection($this->whenLoaded('colors')),
            'sizes'       => Size::collection($this->sizes()),
        ];
    }
}
