<?php

namespace App\GraphQL\Queries;

use App\Models\Photo;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class PhotoQuery extends Query
{
    protected $attributes = [
        'name'        => 'Photo query',
        'description' => 'Get all photos',
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('photo'));
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

        return Photo::all();
    }
}
