<?php

namespace App\Interfaces;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

interface RoomRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Room;
    public function create(array $data): Room;
    public function update(Room $room, array $data): Room;
    public function delete(Room $room): bool;
    public function search(array $criteria): Collection;
    public function getAvailableRooms(): Collection;
    public function getUserRooms(int $userId): Collection;
} 