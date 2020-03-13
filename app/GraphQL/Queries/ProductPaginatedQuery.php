<?php

namespace App\GraphQL\Queries;

use App\Models\Product;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class ProductPaginatedQuery extends Query
{
    protected $attributes = [
        'name'        => 'Products Paginated',
        'description' => 'Get products paginated',
    ];

    public function type(): Type
    {
        return \GraphQL::paginate('product', 'ProductsPagination');
    }

    public function args(): array
    {
        return [
            'limit' => ['name' => 'limit', 'type' => Type::int()],
            'page'  => ['name' => 'page', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return Product::with($fields->getRelations())->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
