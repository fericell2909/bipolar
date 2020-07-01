<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Banner;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class BannerSingleQuery extends Query
{
    protected $attributes = [
        'name' => 'Get banner query',
        'description' => 'Get only one banner by hash id'
    ];

    public function type(): Type
    {
        return \GraphQL::type('banner');
    }

    public function args(): array
    {
        return [
            'hash_id' => ['name' => 'hash_id', 'type' => Type::nonNull(Type::string())]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return Banner::findByHash($args['hash_id']);
    }
}
