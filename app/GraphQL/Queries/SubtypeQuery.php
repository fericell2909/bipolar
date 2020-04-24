<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Subtype;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class SubtypeQuery extends Query
{
    protected $attributes = [
        'name' => 'subtypes',
        'description' => 'Get all subtypes'
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('subtype'));
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

        return Subtype::all();
    }
}
