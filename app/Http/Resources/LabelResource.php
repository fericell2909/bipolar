<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class LabelResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Label|Resource $this */
        return [
            'hash_id' => $this->hash_id,
            'name_es' => $this->getTranslation('name', 'es'),
            'name_en' => $this->getTranslation('name', 'en'),
            'color'   => $this->color,
        ];
    }
}
