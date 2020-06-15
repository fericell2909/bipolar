<?php

namespace App\GraphQL\Mutations;

use App\Models\Banner;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class BannerMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'Banner edition',
        'description' => 'Update a baner',
    ];

    public function type(): Type
    {
        return \Graphql::type('banner');
    }

    public function args(): array
    {
        return [
            'hash_id' => ['name' => 'hash_id', 'type' => Type::nonNull(Type::string())],
            'text_en' => ['name' => 'text_en', 'type' => Type::string()],
            'text_es' => ['name' => 'text_es', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $banner = Banner::findByHash($args['hash_id']);
        $banner->setTranslation('text', 'en', Arr::get($args, 'text_en', $banner->getTranslation('text', 'en')));
        $banner->setTranslation('text', 'es', Arr::get($args, 'text_es', $banner->getTranslation('text', 'es')));
        $banner->save();

        return $banner;
    }
}
