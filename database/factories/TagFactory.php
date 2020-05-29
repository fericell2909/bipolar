<?php

use Faker\Generator as Faker;
use App\Models\Tag;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
