<?php

namespace App\GraphQL\Queries;

use App\Models\Product;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Arr;
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
            'limit'   => ['name' => 'limit', 'type' => Type::nonNull(Type::int())],
            'page'    => ['name' => 'page', 'type' => Type::nonNull(Type::int())],
            'filters' => ['name' => 'filters', 'type' => \GraphQL::type('product_filters')],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $query = Product::with($fields->getRelations())
            ->when(Arr::get($args, 'filters.search', null) !== null, function ($whereProduct) use ($args) {
                /** @var \Illuminate\Database\Query\Builder $whereProduct */
                $search = Arr::get($args, 'filters.search', null);
                $whereProduct->where("name", "LIKE", "%{$search}%");
            });


        return $query->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
