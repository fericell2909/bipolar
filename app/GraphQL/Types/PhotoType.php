<?php

namespace App\GraphQL\Types;

use App\Models\Photo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PhotoType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Photo',
        'description' => 'A type',
        'model'       => Photo::class,
    ];

    public function fields(): array
    {
        return [
            'hash_id' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Hashed ID',
                'alias'       => 'photo_id',
                'resolve'     => function ($root, $args) {
                    return $root->hash_id;
                },
            ],
            'url'     => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Photo url',
            ],
            'order'   => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Appareance order',
            ],
        ];
    }
}
