<?php

use App\GraphQL\Mutations\ProductUpdateMutation;
use App\GraphQL\Queries\CategoryQuery;
use App\GraphQL\Queries\ColorQuery;
use App\GraphQL\Queries\LabelQuery;
use App\GraphQL\Queries\PageQuery;
use App\GraphQL\Queries\PhotoQuery;
use App\GraphQL\Queries\ProductPaginatedQuery;
use App\GraphQL\Queries\ProductQuery;
use App\GraphQL\Queries\SizeQuery;
use App\GraphQL\Queries\StateQuery;
use App\GraphQL\Types\CategoryType;
use App\GraphQL\Types\ColorType;
use App\GraphQL\Types\LabelType;
use App\GraphQL\Types\PageType;
use App\GraphQL\Types\PhotoType;
use App\GraphQL\Types\ProductType;
use App\GraphQL\Types\SizeType;
use App\GraphQL\Types\StateType;
use App\GraphQL\Types\SubtypeType;

return [

    // The prefix for routes
    'prefix' => 'graphql',

    // The routes to make GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Route
    //
    // Example:
    //
    // Same route for both query and mutation
    //
    // 'routes' => 'path/to/query/{graphql_schema?}',
    //
    // or define each route
    //
    // 'routes' => [
    //     'query' => 'query/{graphql_schema?}',
    //     'mutation' => 'mutation/{graphql_schema?}',
    // ]
    //
    'routes' => '{graphql_schema?}',

    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    // Example:
    //
    // 'controllers' => [
    //     'query' => '\Rebing\GraphQL\GraphQLController@query',
    //     'mutation' => '\Rebing\GraphQL\GraphQLController@mutation'
    // ]
    //
    'controllers' => \Rebing\GraphQL\GraphQLController::class.'@query',

    // Any middleware for the graphql route group
    'middleware' => [],

    // Additional route group attributes
    //
    // Example:
    //
    // 'route_group_attributes' => ['guard' => 'api']
    //
    'route_group_attributes' => [],

    // The name of the default schema used when no argument is provided
    // to GraphQL::schema() or when the route is used without the graphql_schema
    // parameter.
    'default_schema' => 'default',

    // The schemas for query and/or mutation. It expects an array of schemas to provide
    // both the 'query' fields and the 'mutation' fields.
    //
    // You can also provide a middleware that will only apply to the given schema
    //
    // Example:
    //
    //  'schema' => 'default',
    //
    //  'schemas' => [
    //      'default' => [
    //          'query' => [
    //              'users' => 'App\GraphQL\Query\UsersQuery'
    //          ],
    //          'mutation' => [
    //
    //          ]
    //      ],
    //      'user' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\ProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //      'user/me' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\MyProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //  ]
    //
    'schemas' => [
        'default' => [
            'query' => [
                'banners' => \App\GraphQL\Queries\BannerQuery::class,
                'banner' => \App\GraphQL\Queries\BannerSingleQuery::class,
                'categories' => CategoryQuery::class,
                'colors' => ColorQuery::class,
                'discount_tasks' => \App\GraphQL\Queries\DiscountTaskQuery::class,
                'labels' => LabelQuery::class,
                'pages' => PageQuery::class,
                'photos' => PhotoQuery::class,
                'products' => ProductQuery::class,
                'products_pagination' => ProductPaginatedQuery::class,
                'sizes' => SizeQuery::class,
                'states' => StateQuery::class,
                'subtypes' => \App\GraphQL\Queries\SubtypeQuery::class,
                'text_conditions' => \App\GraphQL\Queries\TextConditionQuery::class,
                'premium_links' => \App\GraphQL\Queries\PremiumLinkQuery::class,
            ],
            'mutation' => [
                'banner_update' => \App\GraphQL\Mutations\BannerMutation::class,
                'products_update' => ProductUpdateMutation::class,
                'discount_task_creation' => \App\GraphQL\Mutations\DiscountTaskCreation::class,
                'text_condition_creation' => \App\GraphQL\Mutations\TextConditionCreation::class,
                'text_condition_status_updation' => \App\GraphQL\Mutations\TextConditionStatusUpdation::class,
                'text_condition_deletion' => \App\GraphQL\Mutations\TextConditionDeletion::class,
                'text_condition_updation' => \App\GraphQL\Mutations\TextConditionUpdation::class,
                'premium_link_creation' => \App\GraphQL\Mutations\PremiumLinkCreation::class,
                'premium_link_deletion' => \App\GraphQL\Mutations\PremiumLinkDeletion::class,
                'premium_link_updation' => \App\GraphQL\Mutations\PremiumLinkUpdation::class,
            ],
            'method' => ['get', 'post'],
        ],
    ],

    'types' => [
        'banner' => \App\GraphQL\Types\BannerType::class,
        'color' => ColorType::class,
        'discount_task' => \App\GraphQL\Types\DiscountTaskType::class,
        'size' => SizeType::class,
        'state' => StateType::class,
        'category' => CategoryType::class,
        'page' => PageType::class,
        'photo' => PhotoType::class,
        'label' => LabelType::class,
        'product' => ProductType::class,
        'subtype' => SubtypeType::class,
        'text_condition' => \App\GraphQL\Types\TextConditionType::class,
        'premium_link' => \App\GraphQL\Types\PremiumLinkType::class,
        // Input types
        'product_filters' => \App\GraphQL\Inputs\ProductFilters::class,
        'discount_task_filters' => \App\GraphQL\Inputs\DiscountTaskFilters::class,
    ],

    // The types will be loaded on demand. Default is to load all types on each request
    // Can increase performance on schemes with many types
    // Presupposes the config type key to match the type class name property
    'lazyload_types' => false,

    // This callable will be passed the Error object for each errors GraphQL catch.
    // The method should return an array representing the error.
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    'error_formatter' => ['\Rebing\GraphQL\GraphQL', 'formatError'],

    /*
     * Custom Error Handling
     *
     * Expected handler signature is: function (array $errors, callable $formatter): array
     *
     * The default handler will pass exceptions to laravel Error Handling mechanism
     */
    'errors_handler' => ['\Rebing\GraphQL\GraphQL', 'handleErrors'],

    // You can set the key, which will be used to retrieve the dynamic variables
    'params_key' => 'variables',

    /*
     * Options to limit the query complexity and depth. See the doc
     * @ https://webonyx.github.io/graphql-php/security
     * for details. Disabled by default.
     */
    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],

    /*
     * You can define your own pagination type.
     * Reference \Rebing\GraphQL\Support\PaginationType::class
     */
    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class,

    /*
     * Config for GraphiQL (see (https://github.com/graphql/graphiql).
     */
    'graphiql' => [
        'prefix' => '/graphiql',
        'controller' => \Rebing\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql',
        'display' => env('ENABLE_GRAPHIQL', true),
    ],

    /*
     * Overrides the default field resolver
     * See http://webonyx.github.io/graphql-php/data-fetching/#default-field-resolver
     *
     * Example:
     *
     * ```php
     * 'defaultFieldResolver' => function ($root, $args, $context, $info) {
     * },
     * ```
     * or
     * ```php
     * 'defaultFieldResolver' => [SomeKlass::class, 'someMethod'],
     * ```
     */
    'defaultFieldResolver' => null,

    /*
     * Any headers that will be added to the response returned by the default controller
     */
    'headers' => [],

    /*
     * Any JSON encoding options when returning a response from the default controller
     * See http://php.net/manual/function.json-encode.php for the full list of options
     */
    'json_encoding_options' => 0,
];
