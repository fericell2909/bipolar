<?php

namespace App\GraphQL\Types;

use App\Models\Subtype;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SubtypeType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Subtype',
        'description' => 'A subtype',
    ];

    public function fields(): array
    {
        return [
            'hash_id' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Hashed id',
                'alias'       => 'id',
                'resolve'     => function ($root) {
                    /** @var $root Product */
                    return $root->hash_id;
                },
            ],
            'uuid'    => [
                'type' => Type::nonNull(Type::string()),
            ],
            'name_es' => [
                'type'    => Type::nonNull(Type::string()),
                'alias'   => 'name',
                'resolve' => function ($root) {
                    /** @var $root Subtype */
                    return $root->getTranslation('name', 'es');
                },
            ],
            'name_en' => [
                'type'    => Type::nonNull(Type::string()),
                'alias'   => 'name',
                'resolve' => function ($root) {
                    /** @var $root Subtype */
                    return $root->getTranslation('name', 'en');
                },
            ],
            'slug'    => ['type' => Type::nonNull(Type::string())],
            'order'   => ['type' => Type::int()],
            //TODO 'type'    => ['type' => \GraphQL::type('Type')],
        ];
    }
}
