<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Category;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class CategoryQuery extends Query
{
    protected $attributes = [
        'name'        => 'Category query',
        'description' => 'Get all categories',
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('category'));
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

        return Category::all();
    }
}
