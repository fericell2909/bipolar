<?php

namespace App\Http\Resources;

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
            'hash_id'    => $this->hash_id,
            'name'       => $this->name,
            'price'      => $this->price,
            'edit_route' => route('products.photos', $this->slug),
        ];
    }
}
