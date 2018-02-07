<?php

use Faker\Generator as Faker;
use App\Models\Historic;

$factory->define(Historic::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'photo' => 'http://fakeimg.pl/794x527',
        'photo_relative' => 'http://fakeimg.pl/794x527',
        'order' => $faker->numberBetween(1, 100),
    ];
});
