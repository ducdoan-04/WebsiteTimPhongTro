<?php

namespace App\Repositories;

use App\Interfaces\RoomRepositoryInterface;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

class RoomRepository implements RoomRepositoryInterface
{
    public function all(): Collection
    {
        return Room::with('user')->get();
    }

    public function find(int $id): ?Room
    {
        return Room::with('user')->find($id);
    }

    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function update(Room $room, array $data): Room
    {
        $room->update($data);
        return $room;
    }

    public function delete(Room $room): bool
    {
        return $room->delete();
    }

    public function search(array $criteria): Collection
    {
        $query = Room::query()->with('user');

        if (isset($criteria['city'])) {
            $query->where('city', $criteria['city']);
        }

        if (isset($criteria['district'])) {
            $query->where('district', $criteria['district']);
        }

        if (isset($criteria['price_min'])) {
            $query->where('price', '>=', $criteria['price_min']);
        }

        if (isset($criteria['price_max'])) {
            $query->where('price', '<=', $criteria['price_max']);
        }

        if (isset($criteria['area_min'])) {
            $query->where('area', '>=', $criteria['area_min']);
        }

        if (isset($criteria['area_max'])) {
            $query->where('area', '<=', $criteria['area_max']);
        }

        return $query->get();
    }

    public function getAvailableRooms(): Collection
    {
        return Room::with('user')
            ->where('is_available', true)
            ->latest()
            ->get();
    }

    public function getUserRooms(int $userId): Collection
    {
        return Room::where('user_id', $userId)
            ->latest()
            ->get();
    }
} 