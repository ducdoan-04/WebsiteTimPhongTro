<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // Create landlord users
        User::factory()->count(5)->create([
            'role' => 'landlord'
        ])->each(function ($user) {
            // Create rooms for each landlord
            Room::factory()->count(3)->create([
                'user_id' => $user->id
            ]);
        });

        // Create regular users
        User::factory()->count(10)->create([
            'role' => 'user'
        ]);
    }
} 