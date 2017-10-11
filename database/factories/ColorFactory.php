<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Color::class, function (Faker $faker) {
    return [
        'name'        => $faker->colorName,
        'hexadecimal' => $faker->safeHexColor,
    ];
});
