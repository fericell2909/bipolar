<?php

namespace App\GraphQL\Types;

use App\Models\Banner;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BannerType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Banner',
        'description' => 'Banners and color banners',
        'model'       => Banner::class,
    ];

    public function fields(): array
    {
        return [
            'hash_id'        => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Hashed id',
                'alias'       => 'id',
                'resolve'     => function ($root) {
                    /** @var $root Banner */
                    return $root->hash_id;
                },
            ],
            'text_es' => [
                'type'    => Type::string(),
                'resolve' => function ($root) {
                    /** @var $root Banner */
                    return $root->getTranslation('text', 'es');
                },
            ],
            'text_en' => [
                'type'    => Type::string(),
                'resolve' => function ($root) {
                    /** @var $root Banner */
                    return $root->getTranslation('text', 'en');
                },
            ],
        ];
    }
}
