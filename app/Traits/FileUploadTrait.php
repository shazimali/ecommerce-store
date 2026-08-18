<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait FileUploadTrait
{
    /**
     * Upload a file to the specified disk and path.
     * Automatically converts and compresses images to WebP format.
     *
     * @param \Illuminate\Http\UploadedFile|string $file
     * @param string $path
     * @param string $disk
     * @param int $maxWidth
     * @param int $quality
     * @return string|false
     */
    public function uploadFile($file, $path = '/', $disk = 'public', $maxWidth = 700, $quality = 80)
    {
        if ($file instanceof UploadedFile) {
            $mime = $file->getMimeType();
            $imageMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/avif', 'image/bmp'];

            // Optimize raster images to WebP
            if (in_array($mime, $imageMimes) && $mime !== 'image/svg+xml') {
                try {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($file->getRealPath());

                    // Scale down if larger than max width
                    if ($image->width() > $maxWidth) {
                        $image->scaleDown(width: $maxWidth);
                    }

                    $encoded = $image->toWebp($quality);
                    $filename = Str::random(40) . '.webp';
                    $targetPath = ($path === '/' || $path === '') ? $filename : trim($path, '/') . '/' . $filename;

                    Storage::disk($disk)->put($targetPath, (string) $encoded);

                    return $targetPath;
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        }

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
     * Delete multiple files from storage.
     *
     * @param array $paths
     * @param string $disk
     * @return void
     */
    public function deleteMultipleFiles(array $paths, string $disk = 'public')
    {
        foreach ($paths as $path) {
            if (!empty($path)) {
                $this->deleteFile($path, $disk);
            }
        }
    }

    /**
     * Create a resized thumbnail from an uploaded image.
     *
     * @param string $sourcePath Relative path of the uploaded image in storage
     * @param int $width
     * @param int $height
     * @param string $disk
     * @return string|null Name of the saved thumbnail file
     */
    public function createThumbnailFromPath($sourcePath, $width, $height, $disk = 'public')
    {
        if (!$sourcePath || !Storage::disk($disk)->exists($sourcePath)) {
            return null;
        }

        try {
            $absolutePath = Storage::disk($disk)->path($sourcePath);
            $thumbnailName = Str::random(40) . '.webp';
            $thumbnailPath = Storage::disk($disk)->path($thumbnailName);

            $manager = new ImageManager(new Driver());
            $image = $manager->read($absolutePath);
            $image->cover($width, $height);
            $encoded = $image->toWebp(80);
            file_put_contents($thumbnailPath, (string) $encoded);

            return $thumbnailName;
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }
}

