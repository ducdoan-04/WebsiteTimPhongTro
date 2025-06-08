<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(1000000, 10000000),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'district' => $this->faker->city,
            'area' => $this->faker->numberBetween(15, 100),
            'max_people' => $this->faker->numberBetween(1, 5),
            'is_available' => true
        ];
    }
} 