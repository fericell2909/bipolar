<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\DiscountTask;
use App\Models\Product;
use App\Models\Subtype;
use App\Models\Type as TypeModel;
use Carbon\Carbon;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class DiscountTaskCreation extends Mutation
{
    protected $attributes = [
        'name'        => 'discount_task_create',
        'description' => 'Create a discount task',
    ];

    public function type(): Type
    {
        return \GraphQL::type('discount_task');
    }

    public function args(): array
    {
        return [
            'name'         => ['name' => 'name', 'type' => Type::nonNull(Type::string())],
            'begin'        => ['name' => 'begin', 'type' => Type::nonNull(Type::string())],
            'end'          => ['name' => 'end', 'type' => Type::nonNull(Type::string())],
            'products'     => ['name', 'products', 'type' => Type::listOf(Type::string())],
            'subtypes'     => ['name', 'subtypes', 'type' => Type::listOf(Type::string())],
            'types'        => ['name', 'types', 'type' => Type::listOf(Type::string())],
            'discount_pen' => ['name' => 'discount_pen', 'type' => Type::int()],
            'discount_usd' => ['name' => 'discount_usd', 'type' => Type::int()],
            'is_2x1'       => ['name' => 'is_2x1', 'type' => Type::boolean()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $products = collect([]);
        $types = collect([]);
        $subtypes = collect([]);
        $beginDiscount = Carbon::createFromFormat('d/m/Y', $args['begin'])->startOfDay();
        $endDiscount = Carbon::createFromFormat('d/m/Y', $args['end'])->endOfDay();
        if (isset($args['products'])) {
            $products = Product::findByManyHash($args['products']);
        }
        if (isset($args['types'])) {
            $types = TypeModel::findByManyHash($args['types']);
        }
        if (isset($args['subtypes'])) {
            $subtypes = Subtype::findByManyHash($args['subtypes']);
        }
        $typesArray = $types->pluck('id')->toArray();
        $subtypesArray = $subtypes->pluck('id')->toArray();
        $productsArray = $products->pluck('id')->toArray();

        $discountTask = new DiscountTask;
        $discountTask->name = $args['name'];
        if (isset($args['discount_pen']) && isset($args['discount_usd'])) {
            $discountTask->discount_pen = $args['discount_pen'];
            $discountTask->discount_usd = $args['discount_usd'];
        }
        $discountTask->begin = $beginDiscount;
        $discountTask->end = $endDiscount;
        $discountTask->products = count($productsArray) === 0 ? null : $productsArray;
        $discountTask->product_types = count($typesArray) === 0 ? null : $typesArray;
        $discountTask->product_subtypes = count($subtypesArray) === 0 ? null : $subtypesArray;
        if (isset($args['is_2x1'])) {
            $discountTask->is_2x1 = $args['is_2x1'];
        }
        $discountTask->available = true;
        $discountTask->save();

        return $discountTask;
    }
}
