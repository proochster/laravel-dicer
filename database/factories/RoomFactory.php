<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'hash' => substr(sha1(time()), 0, 6) // Get 6 first characters from the hashed time stamp
    ];
});
