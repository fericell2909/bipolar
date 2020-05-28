<?php

use App\Models\Country;
use App\Models\CountryState;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(CountryState::class, function (Faker $faker) {
    return [
        'name'       => $faker->state,
        'country_id' => factory(Country::class)->create()->id,
    ];
});
