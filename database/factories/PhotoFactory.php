<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Photo::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return factory(\App\Models\Product::class)->create()->id;
        },
        'url'        => $faker->imageUrl(317, 210),
        'order'      => $faker->numberBetween(1, 10),
    ];
});
