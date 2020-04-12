<?php

namespace App\GraphQL\Queries;

use App\Models\DiscountTask;
use App\Models\Product;
use App\Models\Subtype;
use App\Models\Type as TypeModel;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class DiscountTaskQuery extends Query
{
    protected $attributes = [
        'name'        => 'discount_tasks',
        'description' => 'Get list of discount tasks',
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('discount_task'));
    }

    public function args(): array
    {
        return [
            'filters' => ['name' => 'filters', 'type' => \GraphQL::type('discount_task_filters')],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        $querySelector = $resolveInfo->getFieldSelection(1);

        $discountTasks = DiscountTask::orderByDesc('id')
            ->when(!is_null(Arr::get($args, 'filters.is_2x1', null)), function ($whereDiscountTask) use ($args) {
                /** @var \Illuminate\Database\Query\Builder $whereDiscountTask */
                $whereDiscountTask->where("is_2x1", Arr::get($args, 'filters.is_2x1'));
            })->get();

        if (Arr::has($querySelector, 'products_model')) {
            $productsIds = $discountTasks->pluck('products')->flatten()->toArray();
            $products = Product::whereIn('id', $productsIds)->with(['stocks.size', 'colors'])->get();

            $discountTasks = $discountTasks->map(function ($discountTask) use ($products) {
                $discountTask->products_model = $products->whereIn('id', $discountTask->products);

                return $discountTask;
            });
        }

        if (Arr::has($querySelector, 'types_model')) {
            $typesIds = $discountTasks->pluck('product_types')->flatten()->toArray();
            $types = TypeModel::find($typesIds);

            $discountTasks = $discountTasks->map(function ($discountTask) use ($types) {
                $discountTask->types_model = $types->whereIn('id', $discountTask->product_types);

                return $discountTask;
            });
        }

        if (Arr::has($querySelector, 'subtypes_model')) {
            $subtypesIds = $discountTasks->pluck('product_subtypes')->flatten()->toArray();
            $subtypes = Subtype::find($subtypesIds);

            $discountTasks = $discountTasks->map(function ($discountTask) use ($subtypes) {
                $discountTask->subtypes_model = $subtypes->whereIn('id', $discountTask->product_subtypes);

                return $discountTask;
            });
        }

        return $discountTasks;
    }
}
