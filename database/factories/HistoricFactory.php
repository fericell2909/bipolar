<?php

use Faker\Generator as Faker;
use App\Models\Historic;

$factory->define(Historic::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'photo' => 'http://fakeimg.pl/794x526',
        'photo_relative' => 'http://fakeimg.pl/794x526',
        'order' => $faker->numberBetween(1, 100),
    ];
});
