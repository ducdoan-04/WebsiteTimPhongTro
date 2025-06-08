<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_room_list()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('home.index');
    }

    public function test_user_can_view_room_details()
    {
        $room = Room::factory()->create();
        
        $response = $this->get("/room/{$room->id}");
        $response->assertStatus(200);
        $response->assertViewIs('home.detail');
        $response->assertSee($room->title);
    }

    public function test_authenticated_user_can_create_room()
    {
        $user = User::factory()->create(['role' => 'landlord']);
        
        $response = $this->actingAs($user)->post('/room', [
            'title' => 'Test Room',
            'description' => 'Test Description',
            'price' => 1000000,
            'address' => 'Test Address',
            'city' => 'Test City',
            'district' => 'Test District',
            'area' => 20,
            'max_people' => 2
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('rooms', [
            'title' => 'Test Room',
            'user_id' => $user->id
        ]);
    }

    public function test_authenticated_user_can_update_room()
    {
        $user = User::factory()->create(['role' => 'landlord']);
        $room = Room::factory()->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)->put("/room/{$room->id}", [
            'title' => 'Updated Room',
            'description' => 'Updated Description',
            'price' => 2000000,
            'address' => 'Updated Address',
            'city' => 'Updated City',
            'district' => 'Updated District',
            'area' => 30,
            'max_people' => 3
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'title' => 'Updated Room'
        ]);
    }

    public function test_authenticated_user_can_delete_room()
    {
        $user = User::factory()->create(['role' => 'landlord']);
        $room = Room::factory()->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)->delete("/room/{$room->id}");
        
        $response->assertRedirect();
        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }
} 