<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Photo::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return factory(\App\Models\Product::class)->create()->id;
        },
        'url'        => 'https://placehold.it/317x210/000000/ffffff',
        'order'      => $faker->numberBetween(1, 10),
    ];
});
