<?php

namespace App\GraphQL\Types;

use App\Models\Page;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PageType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Page',
        'description' => 'A type',
        'model'       => Page::class,
    ];

    public function fields(): array
    {
        return [
            'slug'       => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Page slug',
            ],
            'title_es'   => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Title in spanish',
                'resolve'    => function ($root) {
                    /** @var Page $root */
                    return $root->getTranslation('title', 'es');
                }],
            'title_en'   => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Title in english',
                'resolve'    => function ($root) {
                    /** @var Page $root */
                    return $root->getTranslation('title', 'en');
                }],
            'body_es'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Body in spanish',
                'resolve'    => function ($root) {
                    /** @var Page $root */
                    return $root->getTranslation('body', 'es');
                }],
            'body_en'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Body in english',
                'resolve'    => function ($root) {
                    /** @var Page $root */
                    return $root->getTranslation('body', 'en');
                }],
            'main_image' => [
                'type'        => Type::string(),
                'description' => 'Image of the page',
            ],
        ];
    }
}
