<?php

namespace App\GraphQL\Types;

use App\Models\PremiumLink;
use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PremiumLinkType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'PremiumLink',
        'description' => 'A Premium Link to send users ',
        'model'       => PremiumLink::class,
    ];

    public function fields(): array
    {
        return [
            'hash_id'        => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Slug',
                'alias'       => 'id',
                'resolve'     => function ($root) {
                    return $root->hash_id;
                }],
            'uuid'           => ['type' => Type::nonNull(Type::string())],    
            'name'           => ['type' => Type::nonNull(Type::string())],
            'end'             => ['type' => Type::string(), 'resolve' => function ($root) {
                /** @var $root Product */
                return optional($root->end)->toDateString();
            }],
            'products'       => ['type' => Type::listOf(Type::int())],
            'products_model' => [
                'type'       => Type::listOf(\GraphQL::type('product')),
                'alias'      => 'products',
                'selectable' => false,
                'resolve'    => function ($root) {
                     return $root->products_model;
                },
            ],
            'edit_route'     => [
                'type'       => Type::string(),
                'selectable' => false,
                'resolve'    => function ($root) {
                    /** @var DiscountTask $root */
                    return route('products.premium-links.edit', $root->hash_id);
                },
            ],
            'preview_route'     => [
                'type'       => Type::string(),
                'selectable' => false,
                'resolve'    => function ($root) {
                    return route('shop.premium-links',$root->uuid);
                },
            ],
            'available'      => ['type' => Type::boolean()],
        ];
    }
}
