<?php

namespace App\GraphQL\Types;

use App\Models\Size;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SizeType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Size',
        'description' => 'Sizes from a product',
        'model' => Size::class,
    ];

    public function fields(): array
    {
        return [
            'hash_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Hashed ID',
                'alias' => 'size_id',
                'resolve' => function ($root, $args) {
                    return $root->hash_id;
                }
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of the size',
            ],
        ];
    }
}
