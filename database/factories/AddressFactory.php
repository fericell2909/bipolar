<?php

use App\Models\Address;
use App\Models\AddressType;
use App\Models\CountryState;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Address::class, function (Faker $faker) {
    return [
        'user_id'          => factory(User::class)->create()->id,
        'address_type_id'  => factory(AddressType::class)->create()->id,
        'country_state_id' => factory(CountryState::class)->create()->id,
        'name'             => $faker->name,
        'lastname'         => $faker->lastName,
        'email'            => $faker->email,
        'phone'            => $faker->phoneNumber,
        'address'          => $faker->streetAddress,
        'zip'              => $faker->postcode,
        'main'             => $faker->boolean,
    ];
});
