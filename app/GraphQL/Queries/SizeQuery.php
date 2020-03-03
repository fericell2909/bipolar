<?php

namespace App\GraphQL\Queries;

use App\Models\Size;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class SizeQuery extends Query
{
    protected $attributes = [
        'name'        => 'Size query',
        'description' => 'Get all sizes',
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('size'));
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

        return Size::all();
    }
}
