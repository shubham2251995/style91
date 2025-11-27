<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUploadService
{
    protected $disk = 'public';
    protected $defaultPath = 'uploads';
    protected $interventionAvailable = false;

    public function __construct()
    {
        // Check if Intervention/Image is available
        $this->interventionAvailable = class_exists('Intervention\Image\Facades\Image');
    }

    /**
     * Upload and optimize an image
     */
    public function upload(UploadedFile $file, string $path = null, array $options = []): string
    {
        $path = $path ?? $this->defaultPath;
        
        // Generate unique filename
        $filename = $this->generateFilename($file);
        $fullPath = $path . '/' . $filename;

        // If Intervention/Image is not available, use simple upload
        if (!$this->interventionAvailable) {
            $file->storeAs($path, $filename, $this->disk);
            return Storage::disk($this->disk)->url($fullPath);
        }

        // Use Intervention/Image for optimization
        $image = Image::make($file);

        // Apply optimizations
        if (isset($options['resize'])) {
            $image->resize($options['resize']['width'], $options['resize']['height'], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Optimize quality
        $quality = $options['quality'] ?? 85;
        
        // Save optimized image
        $image->encode($file->getClientOriginalExtension(), $quality);
        Storage::disk($this->disk)->put($fullPath, (string) $image);

        // Create thumbnail if requested
        if ($options['thumbnail'] ?? false) {
            $this->createThumbnail($image, $path, $filename);
        }

        return Storage::disk($this->disk)->url($fullPath);
    }

    /**
     * Upload multiple images
     */
    public function uploadMultiple(array $files, string $path = null, array $options = []): array
    {
        $urls = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $urls[] = $this->upload($file, $path, $options);
            }
        }
        return $urls;
    }

    /**
     * Delete an image
     */
    public function delete(string $url): bool
    {
        $path = str_replace(Storage::disk($this->disk)->url(''), '', $url);
        return Storage::disk($this->disk)->delete($path);
    }

    /**
     * Generate unique filename
     */
    protected function generateFilename(UploadedFile $file): string
    {
        return Str::random(40) . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Create thumbnail
     */
    protected function createThumbnail($image, string $path, string $filename): void
    {
        $thumbnail = clone $image;
        $thumbnail->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $thumbPath = $path . '/thumbnails/' . $filename;
        Storage::disk($this->disk)->put($thumbPath, (string) $thumbnail->encode());
    }

    /**
     * Get optimized image sizes for product images
     */
    public function getProductImageSizes(): array
    {
        return [
            'large' => ['width' => 1200, 'height' => 1200],
            'medium' => ['width' => 600, 'height' => 600],
            'small' => ['width' => 300, 'height' => 300],
        ];
    }
}
