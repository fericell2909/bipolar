<?php

namespace App\GraphQL\Types;

use App\Models\TextCondition;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TextConditionType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'TextCondition',
        'description' => 'A text condition to show in all products',
        'model'       => TextCondition::class,
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
            'name_english'        => [
                'type'        => Type::nonNull(Type::string()),
                'resolve'     => function ($root) {
                    return $root->getTranslation('name','en');
                }],
            'description'    => ['type' => Type::nonNull(Type::string())],
            'description_english'        => [
                'type'        => Type::nonNull(Type::string()),
                'resolve'     => function ($root) {
                    return $root->getTranslation('description','en');
                }],
            'products'       => ['type' => Type::listOf(Type::int())],
            'edit_route'     => [
                'type'       => Type::string(),
                'selectable' => false,
                'resolve'    => function ($root) {
                    return route('products.text-conditions.edit', $root->hash_id);
                },
            ],
            'preview_route'     => [
                'type'       => Type::string(),
                'selectable' => false,
                'resolve'    => function ($root) {
                    return route('products.preview',178);
                },
            ],
            'available'      => ['type' => Type::boolean()],
        ];
    }
}
