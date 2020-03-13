<?php

namespace App\GraphQL\Types;

use App\Models\Color;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ColorType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Color',
        'description' => 'Colors of a product',
        'model' => Color::class,
    ];

    public function fields(): array
    {
        return [
            'hash_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Hashed ID',
                'alias' => 'id',
                'resolve' => function ($root, $args) {
                    return $root->hash_id;
                }
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of the color',
            ],
        ];
    }
}
