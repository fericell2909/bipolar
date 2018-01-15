<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Color::class, function (Faker $faker) {
    return [
        'name' => [
            'es' => "{$faker->colorName} / {$faker->colorName}",
            'en' => "{$faker->colorName} / {$faker->colorName}",
        ],
    ];
});
