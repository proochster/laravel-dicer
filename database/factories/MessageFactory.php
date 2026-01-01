<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $from = User::all()->random()->id;
            $toRoom = Room::all()->random()->id;
        } while ( $from === $toRoom );
        
        return [
            'from' => $from,
            'toRoom' => $toRoom,
            'text' => $this->faker->sentence,
        ];
    }
}
