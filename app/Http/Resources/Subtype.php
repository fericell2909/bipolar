<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Subtype extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Subtype|Resource $this */
        return [
            'hash_id' => $this->hash_id,
            'name'    => $this->name,
            'slug'    => $this->slug,
        ];
    }
}
