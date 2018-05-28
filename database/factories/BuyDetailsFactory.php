<?php

use Faker\Generator as Faker;
use App\Models\BuyDetail;
use App\Models\Buy;
use App\Models\Product;
use App\Models\Stock;

$factory->define(BuyDetail::class, function (Faker $faker) {
    $product = factory(Product::class)->create();
    $stock = factory(Stock::class)->create(['product_id' => $product->id]);

    return [
        'buy_id' => function () {
            return factory(Buy::class)->create()->id;
        },
        'product_id' => $product->id,
        'stock_id' => $stock->id,
        'quantity' => $faker->numberBetween(1, 100),
        'total' => $faker->randomFloat(2, 1, 99999),
    ];
});
