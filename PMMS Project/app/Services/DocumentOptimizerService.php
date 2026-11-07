<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentOptimizerService
{
    /**
     * Maximum dimension (width or height) for uploaded images.
     */
    protected static int $maxDimension = 1920;

    /**
     * Target quality for JPEG compression (1-100).
     */
    protected static int $jpegQuality = 82;

    /**
     * Target quality for WebP compression (1-100).
     */
    protected static int $webpQuality = 80;

    /**
     * Optimize and store an uploaded file on the given disk.
     *
     * @param  UploadedFile  $file
     * @param  string  $directory
     * @param  string  $disk
     * @param  string|null  $customName
     * @return array [path, original_name, file_name, file_size, mime_type, is_optimized]
     */
    public static function optimizeAndStore(UploadedFile $file, string $directory, string $disk = 'public', ?string $customName = null): array
    {
        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType() ?: 'application/octet-stream';
        $originalSize = $file->getSize();

        $baseName = $customName ?: (time() . '_' . Str::random(10));

        // If file is an image (jpg, jpeg, png, webp) and GD is available, optimize it
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']) && extension_loaded('gd')) {
            $optimizedData = self::optimizeImage($file, $extension);
            if ($optimizedData !== null) {
                $fileName = $baseName . '.' . $optimizedData['extension'];
                $targetPath = trim($directory, '/') . '/' . $fileName;

                Storage::disk($disk)->put($targetPath, $optimizedData['content']);
                $savedSize = strlen($optimizedData['content']);

                return [
                    'path' => $targetPath,
                    'file_name' => $fileName,
                    'original_name' => $originalName,
                    'file_size' => $savedSize,
                    'mime_type' => $optimizedData['mime'],
                    'is_optimized' => true,
                    'saved_bytes' => max(0, $originalSize - $savedSize),
                ];
            }
        }

        // For PDFs, docs, or if GD failed: store safely as-is
        $fileName = $baseName . '.' . $extension;
        $path = $file->storeAs($directory, $fileName, $disk);
        $savedSize = Storage::disk($disk)->exists($path) ? Storage::disk($disk)->size($path) : $originalSize;

        return [
            'path' => $path,
            'file_name' => $fileName,
            'original_name' => $originalName,
            'file_size' => $savedSize,
            'mime_type' => $mime,
            'is_optimized' => false,
            'saved_bytes' => 0,
        ];
    }

    /**
     * Optimize an image using GD: resize if huge, strip EXIF, and recompress.
     */
    protected static function optimizeImage(UploadedFile $file, string $extension): ?array
    {
        $tempPath = $file->getRealPath();
        if (!$tempPath || !file_exists($tempPath)) {
            return null;
        }

        $img = null;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                if (function_exists('imagecreatefromjpeg')) {
                    $img = @imagecreatefromjpeg($tempPath);
                }
                break;
            case 'png':
                if (function_exists('imagecreatefrompng')) {
                    $img = @imagecreatefrompng($tempPath);
                }
                break;
            case 'webp':
                if (function_exists('imagecreatefromwebp')) {
                    $img = @imagecreatefromwebp($tempPath);
                }
                break;
        }

        if (!$img) {
            return null;
        }

        $width = imagesx($img);
        $height = imagesy($img);

        if ($width <= 0 || $height <= 0) {
            imagedestroy($img);
            return null;
        }

        // Downscale proportionately if dimensions exceed maximum
        $maxDim = self::$maxDimension;
        if ($width > $maxDim || $height > $maxDim) {
            if ($width >= $height) {
                $newWidth = $maxDim;
                $newHeight = (int) round(($height / $width) * $maxDim);
            } else {
                $newHeight = $maxDim;
                $newWidth = (int) round(($width / $height) * $maxDim);
            }

            $resizedImg = imagecreatetruecolor($newWidth, $newHeight);

            // Handle transparency for PNG/WebP
            if (in_array($extension, ['png', 'webp'])) {
                imagealphablending($resizedImg, false);
                imagesavealpha($resizedImg, true);
                $transparent = imagecolorallocatealpha($resizedImg, 255, 255, 255, 127);
                imagefilledrectangle($resizedImg, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($resizedImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($img);
            $img = $resizedImg;
        }

        // Buffer compressed image content
        ob_start();
        $targetExtension = $extension;
        $targetMime = 'image/jpeg';

        if ($extension === 'png') {
            // Recompress PNG with level 7
            imagepng($img, null, 7);
            $targetMime = 'image/png';
        } elseif ($extension === 'webp' && function_exists('imagewebp')) {
            imagewebp($img, null, self::$webpQuality);
            $targetMime = 'image/webp';
        } else {
            // Default to high efficiency JPEG
            imagejpeg($img, null, self::$jpegQuality);
            $targetExtension = 'jpg';
            $targetMime = 'image/jpeg';
        }

        $content = ob_get_clean();
        imagedestroy($img);

        if (!$content) {
            return null;
        }

        return [
            'content' => $content,
            'extension' => $targetExtension,
            'mime' => $targetMime,
        ];
    }
}
