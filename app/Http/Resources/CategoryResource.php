<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $isAdmin = \Auth::guard('admin')->check();
        /** @var \App\Models\Category $category */
        $category = $this;

        return [
            'id' => $this->when($isAdmin, $category->id),
            'hash_id' => $category->hash_id,
            'name' => $category->name,
        ];
    }
}
