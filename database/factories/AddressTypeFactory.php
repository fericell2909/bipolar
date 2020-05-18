<?php

use App\Models\AddressType;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(AddressType::class, function (Faker $faker) {
    return ['name' => $faker->word];
});
