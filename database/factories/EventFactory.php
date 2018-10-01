<?php

use App\User;
use App\Event;
use App\Place;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $startTime = Carbon::createFromTimeStamp(
        $faker->dateTimeBetween('now', '+14 days')->getTimestamp()
    );

    return [
        'name' => $faker->sentence,
        'start_time' => $startTime,
        'end_time' => $startTime->copy()->addHour(),
        'place_id' => function () {
            return factory(Place::class)->create()->id;
        },
        'description' => $faker->paragraphs(1, true),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'approved_by' => function () {
            return factory(User::class)->create()->id;
        },
        'approved_at' => Carbon::now(),
    ];
});
