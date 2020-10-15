<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Carbon\Carbon;
use App\Models\PremiumLink;
use App\Models\Product;

use Illuminate\Support\Str;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class PremiumLinkCreation extends Mutation
{
    protected $attributes = [
        'name'        => 'premium_link',
        'description' => 'Create a Permium Link',
    ];

    public function type(): Type
    {
        return \GraphQL::type('premium_link');
    }

    public function args(): array
    {
        return [
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

        $products = collect([]);


        $endPremiumLink = Carbon::createFromFormat('d/m/Y', $args['end'])->endOfDay();

        if (isset($args['products'])) {
            $products = Product::findByManyHash($args['products']);
        }
        

        $productsArray = $products->pluck('id')->toArray();

        $premiumLink = new PremiumLink();
        $premiumLink->name = $args['name'];

        $premiumLink->end = $endPremiumLink;
        $premiumLink->products = count($productsArray) === 0 ? null : $productsArray;

        $premiumLink->available = true;
        $premiumLink->uuid = Str::uuid();
        $premiumLink->save();

        return $premiumLink;

    }
}
