<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    return [
        'name'     => $faker->word,
        'slug'     => $faker->slug,
        'subtitle' => $faker->optional()->word,
        'price'    => $faker->randomFloat(2, 10, 3000),
        'active'   => $faker->optional()->dateTime,
    ];
});
