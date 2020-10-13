<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\PremiumLink;
use App\Models\Product;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class PremiumLinkUpdation extends Mutation
{
    protected $attributes = [
        'name'        => 'products_premium_link',
        'description' => 'Update premium links',
    ];

    public function type(): Type
    {
        return \GraphQL::type('premium_link');
    }

    public function args(): array
    {
        return [
            'uuid'         => ['name' => 'uuid', 'type' => Type::nonNull(Type::string())],
            'name'         => ['name' => 'name', 'type' => Type::nonNull(Type::string())],
            'end'          => ['name' => 'end', 'type' => Type::nonNull(Type::string())],
            'products'     => ['name', 'products', 'type' => Type::listOf(Type::string())],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        // only one text condition available

        $premiumlink = PremiumLink::where('uuid', $args['uuid'])->first();

        $premiumlink->name = $args['name'];
        $premiumlink->end = Carbon::createFromFormat('d/m/Y', $args['end'])->endOfDay();


        if (isset($args['products'])) {
            $products = Product::findByManyHash($args['products']);
        }
        

        $productsArray = $products->pluck('id')->toArray();

        $premiumlink->products = count($productsArray) === 0 ? null : $productsArray;

        $premiumlink->save();
        
        return $premiumlink;

    }
}
