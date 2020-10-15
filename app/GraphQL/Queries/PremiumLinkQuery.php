<?php

namespace App\GraphQL\Queries;

use App\Models\PremiumLink;
use App\Models\Product;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class PremiumLinkQuery extends Query
{
    protected $attributes = [
        'name'        => 'premium_links',
        'description' => 'Get list of premium links',
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('premium_link'));
    }

    public function args(): array
    {
        return [
            'uuid'    => ['name' => 'uuid', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        $querySelector = $resolveInfo->getFieldSelection(1);

        if(@$args['uuid'] == ''){
            //if(@$args['uuid']){
                $premiumlinks = PremiumLink::where('id','>',0)->orderByDesc('id')->get();
            } else {
                
                $premiumlinks = PremiumLink::where('uuid',$args['uuid'])->orderByDesc('id')->get();
    
            }
        

             if (Arr::has($querySelector, 'products_model')) {

                $productsIds = $premiumlinks->pluck('products')->reject($this->nonEmptyValues())->flatten()->toArray();

                $products = Product::whereIn('id', $productsIds)->with(['stocks.size', 'colors'])->get();
    
                $premiumlinks = $premiumlinks->map(function ($premiumlink) use ($products) {
                    $premiumlink->products_model = $products->whereIn('id', $premiumlink->products);
    
                    return $premiumlink;
                });
            } 


        return $premiumlinks;

    }

    private function nonEmptyValues()
    {
        return function ($element) {
            return is_null($element);
        };
    }
}