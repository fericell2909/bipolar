<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Label;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class LabelQuery extends Query
{
    protected $attributes = [
        'name'        => 'All labels',
        'description' => 'Get all labels',
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('label'));
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

        return Label::all();
    }
}
