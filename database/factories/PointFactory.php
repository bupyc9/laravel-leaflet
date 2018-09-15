<?php

use Faker\Generator as Faker;

$factory->define(\App\Point::class, function (Faker $faker) {
    return [
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
    ];
});
