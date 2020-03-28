<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use App\User;
use App\Room;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {

    do {
        $from = User::all()->random()->id;
        $toRoom = Room::all()->random()->id;
    } while ( $from === $toRoom );
    return [
        'from' => $from,
        'toRoom' => $toRoom,
        'text' => $faker->sentence,
    ];
});
