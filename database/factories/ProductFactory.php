<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    return [
        'state_id'      => $faker->optional()->numberBetween(1, 3),
        'name'          => $faker->unique()->numberBetween(100, 300),
        'price'         => $faker->randomFloat(2, 10, 3000),
        'weight'        => $faker->optional()->randomFloat(2, 10, 3000),
        'description'   => $faker->optional()->paragraph(2),
        'free_shipping' => $faker->boolean(30),
        'is_salient'    => $faker->optional()->dateTime(),
    ];
});
