<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'lastname'       => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('123456'),
        'remember_token' => str_random(10),
        'active'         => $faker->optional()->dateTime,
    ];
});
