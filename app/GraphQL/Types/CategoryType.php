<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Category',
        'description' => 'A type',
        'model'       => Category::class,
    ];

    public function fields(): array
    {
        return [
            'hash_id' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Hashed ID',
                'alias'       => 'state_id',
                'resolve'     => function ($root, $args) {
                    return $root->hash_id;
                },
            ],
            'name'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Name of the state',
            ],
        ];
    }
}
