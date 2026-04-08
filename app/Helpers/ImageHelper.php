<?php

namespace App\Helpers;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function uploadImage(UploadedFile $file, $folder = 'images')
    {
        $path = $file->store($folder, 'public');
        return Storage::url($path);
    }

    public static function deleteImage($imageUrl)
    {
        $path = str_replace('/storage/', '', $imageUrl);
        Storage::disk('public')->delete($path);
    }
}