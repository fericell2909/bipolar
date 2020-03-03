<?php

namespace App\GraphQL\Queries;

use App\Models\Color;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class ColorQuery extends Query
{
    protected $attributes = [
        'name' => 'Color query',
        'description' => 'Get all colors'
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('color'));
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

        return Color::all();
    }
}
