<?php

namespace App\GraphQL\Types;

use App\Models\State;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class StateType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'State',
        'description' => 'State of the products',
        'model'       => State::class,
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
            'color'   => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Color of the state',
            ],
            'html'    => [
                'type'        => Type::string(),
                'description' => "Label build from the admin",
                'resolve'     => function ($root, $args) {
                    /** @var State $root */
                    return $root->getAdminHtml();
                },
            ],
        ];
    }
}
