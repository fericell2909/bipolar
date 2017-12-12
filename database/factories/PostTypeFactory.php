<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\PostType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
