<?php

use App\Models\Page;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Page::class, function (Faker $faker) {
    return [
        'slug'  => $faker->word,
        'title' => $faker->word,
        'body'  => $faker->paragraphs(3),
    ];
});
