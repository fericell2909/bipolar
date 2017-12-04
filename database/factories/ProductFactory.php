<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    return [
        'state_id'   => $faker->optional()->numberBetween(1, 3),
        'name'       => $faker->unique()->numberBetween(100, 300),
        'price'      => $faker->randomFloat(2, 10, 3000),
        'active'     => $faker->optional()->dateTime,
        'is_salient' => $faker->optional()->dateTime(),
        'is_home'    => $faker->optional()->dateTime(),
    ];
});
