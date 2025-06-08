<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasImage
{
    public function uploadImage(UploadedFile $image, $path = 'images')
    {
        return $image->store($path, 'public');
    }

    public function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function getImageUrl($path)
    {
        if (!$path) {
            return asset('images/no-image.jpg');
        }

        return Storage::disk('public')->url($path);
    }

    public function updateImage(UploadedFile $newImage, $oldPath = null, $path = 'images')
    {
        if ($oldPath) {
            $this->deleteImage($oldPath);
        }

        return $this->uploadImage($newImage, $path);
    }
} 