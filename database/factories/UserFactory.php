<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'lastname'       => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('123456'),
        'birthday_date'  => $faker->optional()->date(),
        'remember_token' => Str::random(10),
        'active'         => $faker->optional()->dateTime,
    ];
});
