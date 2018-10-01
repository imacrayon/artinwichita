<?php

use App\User;
use App\Place;
use Faker\Generator as Faker;

$factory->define(Place::class, function (Faker $faker) {
    $name = $faker->sentence;

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'address_line_1' => $faker->streetName,
        'address_line_2' => null,
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'postal_code' => $faker->postcode,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'profile' => [
            'website' => $faker->url,
            'email' => $faker->safeEmail,
            'phone' => $faker->phoneNumber,
        ],
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
