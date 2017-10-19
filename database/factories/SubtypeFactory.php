<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Subtype::class, function (Faker $faker) {
    return [
        'type_id' => function () {
            return factory(\App\Models\Type::class)->create()->id;
        },
        'name' => $faker->word,
    ];
});
