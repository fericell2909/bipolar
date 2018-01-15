<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    return [
        'state_id'      => $faker->optional()->numberBetween(1, 3),
        'name'          => [
            'es' => $faker->unique()->numberBetween(100, 300),
            'en' => $faker->unique()->numberBetween(100, 300),
        ],
        'price'         => $faker->numberBetween(300, 500),
        'price_dolar'   => $faker->numberBetween(300, 500),
        'weight'        => $faker->optional()->randomFloat(2, 10, 3000),
        'description'   => [
            'es' => $faker->optional()->paragraph(2),
            'en' => $faker->optional()->paragraph(2),
        ],
        'free_shipping' => $faker->boolean(30),
        'is_salient'    => $faker->optional()->dateTime(),
    ];
});
