<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\Type::class, function (Faker $faker) {
    return [
        'name' => [
            'en' => $faker->word,
            'es' => $faker->word,
        ],
    ];
});
