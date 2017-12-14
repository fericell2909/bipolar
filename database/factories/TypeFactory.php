<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Type::class, function (Faker $faker) {
    return [
        'name' => [
            'en' => $faker->word,
            'es' => $faker->word,
        ],
    ];
});
