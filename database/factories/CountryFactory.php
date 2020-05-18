<?php

use App\Models\Country;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Country::class, function (Faker $faker) {
    return [
        'sortname'  => $faker->countryCode,
        'name'      => $faker->country,
        'phonecode' => $faker->numberBetween(111111, 333333),
    ];
});
