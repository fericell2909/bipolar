<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Banner;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class BannerQuery extends Query
{
    protected $attributes = [
        'name' => 'Banner query',
        'description' => 'Get all banners'
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('banner'));
    }

    public function args(): array
    {
        return [

        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return Banner::all();
    }
}
