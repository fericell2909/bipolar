<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Page $page */
        $page = $this;

        return [
            'title_es' => $page->getTranslation('title', 'es'),
            'title_en' => $page->getTranslation('title', 'en'),
            'body_es'  => $page->getTranslation('body', 'es'),
            'body_en'  => $page->getTranslation('body', 'en'),
        ];
    }
}
