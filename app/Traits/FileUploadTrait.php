<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait FileUploadTrait
{
    /**
     * Upload a file to the specified disk and path.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @param string $disk
     * @return string|false
     */
    public function uploadFile($file, $path = '/', $disk = 'public')
    {
        return Storage::disk($disk)->put($path, $file);
    }

    /**
     * Delete a file from the specified disk.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    public function deleteFile($path, $disk = 'public')
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        return false;
    }

    /**
     * Create a resized thumbnail from an uploaded image.
     *
     * @param string $sourcePath Relative path of the uploaded image in storage
     * @param int $width
     * @param int $height
     * @param string $disk
     * @return string Name of the saved thumbnail file
     */
    public function createThumbnailFromPath($sourcePath, $width, $height, $disk = 'public')
    {
        // Get absolute path
        $absolutePath = Storage::disk($disk)->path($sourcePath);
        
        // Generate thumbnail name
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        $thumbnailName = time() . '.' . $extension;
        $thumbnailPath = Storage::disk($disk)->path($thumbnailName);

        // Resize and save
        $manager = new ImageManager(new Driver());
        $image = $manager->read($absolutePath);
        $image->resize($width, $height);
        $image->save($thumbnailPath);

        return $thumbnailName;
    }
}
