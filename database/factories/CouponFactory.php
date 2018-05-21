<?php

use Faker\Generator as Faker;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Type;
use App\Models\Subtype;

$factory->define(Coupon::class, function (Faker $faker) {
    return [
        'type_id'             => $faker->randomElement([
            config('constants.PERCENTAGE_DISCOUNT_ID'),
            config('constants.QUANTITY_DISCOUNT_ID'),
        ]),
        'code'                => mb_strtoupper($faker->unique()->word),
        'amount_pen'          => $faker->numberBetween(10, 30),
        'amount_usd'          => $faker->numberBetween(10, 30),
        'frequency'           => $faker->numberBetween(0, 10),
        'minimum_pen'         => $faker->randomFloat(2, 10, 30),
        'minimum_usd'         => $faker->randomFloat(2, 10, 30),
        'begin'               => $faker->dateTimeBetween('-1 years', 'yesterday')->format('Y-m-d H:i:s'),
        'end'                 => $faker->dateTimeBetween('+10 days', '+13 days')->format('Y-m-d H:i:s'),
        'products'            => factory(Product::class, 2)->create()->pluck('id')->toArray(),
        'product_subtypes'    => factory(Type::class, 2)->create()->pluck('id')->toArray(),
        'product_types'       => factory(Subtype::class, 2)->create()->pluck('id')->toArray(),
        'discounted_products' => $faker->boolean,
    ];
});

$factory->state(Coupon::class, 'percentage', function (Faker $faker) {
    return ['type_id' => config('constants.PERCENTAGE_DISCOUNT_ID')];
});

$factory->state(Coupon::class, 'quantity', function (Faker $faker) {
    return ['type_id' => config('constants.QUANTITY_DISCOUNT_ID')];
});

$factory->state(Coupon::class, 'with_discounted', function (Faker $faker) {
    return ['discounted_products' => true];
});

$factory->state(Coupon::class, 'without_discounted', function (Faker $faker) {
    return ['discounted_products' => false];
});
