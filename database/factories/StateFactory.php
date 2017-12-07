<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\State::class, function (Faker $faker) {
    return [
        'name'  => $faker->word,
        'color' => $faker->word,
    ];
});
