<?php

namespace App\GraphQL\Types;

use App\Models\Label;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LabelType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Label',
        'description' => 'Label to indicate status of a product',
        'model'       => Label::class,
    ];

    public function fields(): array
    {
        return [
            'hash_id' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Slug',
                'resolve'     => function ($root) {
                    /** @var Label $root */
                    return $root->hash_id;
                }],
            'slug'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Slug',
            ],
            'name_es' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Name in spanish',
                'alias'       => 'name',
                'resolve'     => function ($root) {
                    /** @var Label $root */
                    return $root->getTranslation('name', 'es');
                }],
            'name_en' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Name in english',
                'alias'       => 'name',
                'resolve'     => function ($root) {
                    /** @var Label $root */
                    return $root->getTranslation('name', 'en');
                }],
            'color'   => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Color',
            ],
        ];
    }
}
