<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use App\Models\Settings;
use App\Models\State;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class ProductUpdateMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'product',
        'description' => 'Operations with Product',
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('product'));
    }

    public function args(): array
    {
        return [
            'products_id'    => ['name' => 'products_id', 'type' => Type::nonNull(Type::listOf(Type::id()))],
            'operation_name' => ['name' => 'operation_name', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $productsIds = $args['products_id'];
        $operationName = $args['operation_name'];

        switch ($operationName) {
            case 'change_published':
                $this->updateState($productsIds, "published");
                break;
            case 'change_draft':
                $this->updateState($productsIds, "draft");
                break;
            case 'change_pending':
                $this->updateState($productsIds, "pending");
                break;
            case 'change_reviewed':
                $this->updateState($productsIds, "reviewed");
                break;
            case 'activate_salient':
                $this->toggleSalient($productsIds, true);
                break;
            case 'deactivate_salient':
                $this->toggleSalient($productsIds, false);
                break;
            case 'activate_free':
                $this->toggleFreeShipping($productsIds, true);
                break;
            case 'deactivate_free':
                $this->toggleFreeShipping($productsIds, false);
                break;
            case 'dolar_price':
                $this->changeDolarPrice($productsIds);
                break;
        }

        return Product::findByManyHash($args['products_id']);
    }

    public function updateState(array $productIds, string $stateSelected)
    {
        $products = Product::findByManyHash($productIds);

        switch ($stateSelected) {
            case "draft":
                $state = State::find(config('constants.STATE_PREVIEW_ID'));
                break;
            case "pending":
                $state = State::find(config('constants.STATE_WAITING_ID'));
                break;
            case "published":
                $state = State::find(config('constants.STATE_ACTIVE_ID'));
                break;
            case "reviewed":
                $state = State::find(config('constants.STATE_REVIEW_ID'));
                break;
            default:
                $state = State::first();
                break;
        }

        $products->each(function ($product) use ($state) {
            /** @var Product $product */
            $product->state()->associate($state);
            $product->save();
        });
    }

    public function toggleSalient(array $productIds, bool $activate)
    {
        $products = Product::findByManyHash($productIds);

        $products->each(function ($product) use ($activate) {
            /** @var Product $product */
            $product->is_salient = ($activate ? now() : null);
            $product->save();
        });
    }

    public function toggleFreeShipping(array $productIds, bool $activate)
    {
        $products = Product::findByManyHash($productIds);

        $products->each(function ($product) use ($activate) {
            /** @var Product $product */
            $product->free_shipping = $activate;
            $product->save();
        });
    }

    public function changeDolarPrice(array $productIds)
    {
        $products = Product::findByManyHash($productIds);
        /** @var Settings $settings */
        $settings = Settings::first();

        $dolarPrice = $settings->dolar_change ?? 3.30;

        $products->each(function ($product) use ($dolarPrice) {
            /** @var Product $product */
            $product->price_dolar = round($product->price / $dolarPrice);
            $product->save();
        });
    }
}
