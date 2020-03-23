<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ProductType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Product',
        'description' => 'A product',
        'model'       => Product::class,
    ];

    public function fields(): array
    {
        return [
            'hash_id'               => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Hashed id',
                'alias'       => 'id',
                'resolve'     => function ($root) {
                    /** @var $root Product */
                    return $root->hash_id;
                },
            ],
            'slug'                  => ['type' => Type::nonNull(Type::string())],
            'name_es'               => [
                'type'    => Type::nonNull(Type::string()),
                'resolve' => function ($root) {
                    /** @var $root Product */
                    return $root->getTranslation('name', 'es');
                },
            ],
            'name_en'               => [
                'type'    => Type::nonNull(Type::string()),
                'resolve' => function ($root) {
                    /** @var $root Product */
                    return $root->getTranslation('name', 'en');
                },
            ],
            'description_es'        => ['type' => Type::string(), 'resolve' => function ($root) {
                /** @var $root Product */
                return $root->getTranslation('description', 'es');
            }],
            'description_en'        => ['type' => Type::string(), 'resolve' => function ($root) {
                /** @var $root Product */
                return $root->getTranslation('description', 'en');
            }],
            'weight'                => ['type' => Type::float()],
            'price_pen'             => ['type' => Type::nonNull(Type::float()), 'resolve' => function ($root) {
                /** @var $root Product */
                return $root->price;
            }],
            'price_usd'             => ['type' => Type::nonNull(Type::float()), 'resolve' => function ($root) {
                /** @var $root Product */
                return $root->price_dolar;
            }],
            'price_pen_discount'    => ['type' => Type::float()],
            'price_usd_discount'    => ['type' => Type::float()],
            'discount_pen'          => ['type' => Type::int()],
            'discount_usd'          => ['type' => Type::int()],
            'begin_discount'        => ['type' => Type::string(), 'resolve' => function ($root) {
                /** @var $root Product */
                return optional($root->begin_discount)->toDateString();
            }],
            'end_discount'          => ['type' => Type::string(), 'resolve' => function ($root) {
                /** @var $root Product */
                return optional($root->end_discount)->toDateString();
            }],
            'publish_date'          => ['type' => Type::string(), 'resolve' => function ($root) {
                /** @var $root Product */
                return optional($root->publish_date)->toDateTimeString();
            }],
            'free_shipping'         => ['type' => Type::nonNull(Type::boolean())],
            'is_showroom_sale'      => ['type' => Type::nonNull(Type::boolean())],
            'is_salient'            => ['type' => Type::nonNull(Type::boolean()), 'resolve' => function ($root) {
                /** @var $root Product */
                return (boolean)$root->is_salient;
            }],
            'fullname'              => [
                'type'        => Type::string(),
                'description' => '[Requires colors] Get product fullname',
                'resolve'     => function ($root) {
                    /** @var $root Product */
                    $fullName = $root->getTranslation('name', 'es') . "/" . $root->getTranslation('name', 'en');
                    if ($root->relationLoaded('colors')) {
                        $fullName = $root->getTranslation('name', 'es') . "/" . $root->getTranslation('name', 'en') . " - " . $root->colors->implode('name', ',');
                    }

                    return $fullName;
                },
            ],
            'route_preview'         => ['type' => Type::string(), 'resolve' => function ($root) {
                /** @var $root Product */
                return route('products.preview', $root->slug);
            }],
            'route_edit'            => ['type' => Type::string(), 'resolve' => function ($root) {
                /** @var $root Product */
                return route('products.photos', $root->slug);
            }],
            'route_shop'            => ['type' => Type::string(), 'resolve' => function ($root) {
                /** @var $root Product */
                return route('shop.product', $root->slug);
            }],
            'created_at_month_year' => ['type' => Type::string(), 'resolve' => function ($root) {
                /** @var $root Product */
                return $root->created_at->format('n-Y');
            }],
            'first_photo_url'         => [
                'type'        => Type::string(),
                'description' => "First photo url",
                'resolve'     => function ($root) {
                    /** @var $root Product */
                    return optional($root->photos->first())->url;
                },
            ],
            'colors'                => ['type' => Type::listOf(\GraphQL::type('color'))],
            'photos'                => ['type' => Type::listOf(\GraphQL::type('photo'))],
            'state'                 => ['type' => \GraphQL::type('state')],
            'label'                 => ['type' => \GraphQL::type('label')],
            'subtypes'              => ['type' => Type::listOf(\GraphQL::type('subtype'))],
            //TODO 'sizes'                 => Size::collection($product->sizes_mapped()),
        ];
    }
}
