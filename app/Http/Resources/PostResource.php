<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Post;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Post $post */
        $post = $this;
        return [
            'id' => (int)$post->id,
            'hash_id' => (string)$post->hash_id,
            'title_es' => (string)$post->getTranslation('title', 'es'),
            'title_en' => (string)$post->getTranslation('title', 'en'),
            'content_es' => $post->getTranslation('content', 'es'),
            'content_en' => $post->getTranslation('content', 'en'),
            'categories' => $this->whenLoaded('categories', CategoryResource::collection($post->categories)),
            'tags' => $this->whenLoaded('tags', TagResource::collection($post->tags)),
            'state' => $this->whenLoaded('state', new State($post->state)),
        ];
    }
}
