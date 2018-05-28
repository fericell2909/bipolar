<?php

use Faker\Generator as Faker;
use App\Models\Address;
use App\Models\AddressType;
use App\Models\CountryState;
use App\Models\User;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'address_type_id' => AddressType::all()->random()->id,
        'country_state_id' => CountryState::all()->random()->id,
        'name' => $faker->name,
        'lastname' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'main' => $faker->boolean,
    ];
});
