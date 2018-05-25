<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Type extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Type $type */
        $type = $this;

        return [
            'id'       => $this->when(\Auth::guard('admin')->check(), $type->id),
            'hash_id'  => $type->hash_id,
            'name'     => $type->name,
            'slug'     => $type->slug,
            'subtypes' => Subtype::collection($this->whenLoaded('subtypes')),
        ];
    }
}
