<?php

namespace App\Services;

use App\Models\Room;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RoomService
{
    public function create(array $data, UploadedFile $image = null)
    {
        if ($image) {
            $data['image'] = $this->uploadImage($image);
        }

        return Room::create($data);
    }

    public function update(Room $room, array $data, UploadedFile $image = null)
    {
        if ($image) {
            if ($room->image) {
                Storage::delete($room->image);
            }
            $data['image'] = $this->uploadImage($image);
        }

        $room->update($data);
        return $room;
    }

    public function delete(Room $room)
    {
        if ($room->image) {
            Storage::delete($room->image);
        }
        
        return $room->delete();
    }

    protected function uploadImage(UploadedFile $image)
    {
        return $image->store('rooms', 'public');
    }
} 