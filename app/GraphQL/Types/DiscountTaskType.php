<?php

namespace App\GraphQL\Types;

use App\Models\DiscountTask;
use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DiscountTaskType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'DiscountTask',
        'description' => 'A discount task to apply discount or 2x1',
        'model'       => DiscountTask::class,
    ];

    public function fields(): array
    {
        return [
            'hash_id'        => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Slug',
                'alias'       => 'id',
                'resolve'     => function ($root) {
                    /** @var DiscountTask $root */
                    return $root->hash_id;
                }],
            'name'           => ['type' => Type::nonNull(Type::string())],
            'discount_pen'   => ['type' => Type::int()],
            'discount_usd'   => ['type' => Type::int()],
            'begin'          => ['type' => Type::nonNull(Type::string())],
            'end'            => ['type' => Type::nonNull(Type::string())],
            'products_model' => [
                'type'       => Type::listOf(\GraphQL::type('product')),
                'alias'      => 'products',
                'selectable' => false,
                'resolve'    => function ($root) {
                    return $root->products_model;
                },
            ],
            'subtypes_model' => [
                'type'       => Type::listOf(\GraphQL::type('subtype')),
                'alias'      => 'products_subtypes',
                'selectable' => false,
                'resolve'    => function ($root) {
                    return $root->subtypes_model;
                }],
            'is_2x1'         => ['type' => Type::boolean()],
            'available'      => ['type' => Type::boolean()],
            'executed'       => ['type' => Type::boolean()],
        ];
    }
}
