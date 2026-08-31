<?php

namespace App\Support;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageCompressor
{
    /**
     * Resize (jika perlu) + kompres foto sebagai JPEG, lalu simpan ke storage.
     * Mengembalikan nama file yang tersimpan.
     */
    public static function store(
        UploadedFile $file,
        string $disk,
        string $directory,
        int $maxDimension = 800,
        int $quality = 80
    ): string {
        $image = self::load($file->getRealPath(), $file->getMimeType());

        // Format tidak dikenali GD (mis. HEIC) -> simpan apa adanya, tidak dikompres.
        if (! $image instanceof GdImage) {
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $file->storeAs($directory, $filename, $disk);

            return $filename;
        }

        $image = self::applyExifOrientation($image, $file->getRealPath(), $file->getMimeType());
        $image = self::resizeIfNeeded($image, $maxDimension);
        $image = self::flattenToWhite($image);

        ob_start();
        imagejpeg($image, null, $quality);
        $contents = ob_get_clean();
        imagedestroy($image);

        $filename = Str::uuid().'.jpg';
        Storage::disk($disk)->put($directory.'/'.$filename, $contents);

        return $filename;
    }

    private static function load(string $path, string $mime): ?GdImage
    {
        $image = match ($mime) {
            'image/jpeg', 'image/pjpeg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/gif' => @imagecreatefromgif($path),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            default => false,
        };

        return $image instanceof GdImage ? $image : null;
    }

    private static function applyExifOrientation(GdImage $image, string $path, string $mime): GdImage
    {
        if ($mime !== 'image/jpeg' || ! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($path);
        $orientation = $exif['Orientation'] ?? 1;

        $rotated = match ($orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => null,
        };

        if ($rotated instanceof GdImage) {
            imagedestroy($image);

            return $rotated;
        }

        return $image;
    }

    private static function resizeIfNeeded(GdImage $image, int $maxDimension): GdImage
    {
        $width = imagesx($image);
        $height = imagesy($image);

        if ($width <= $maxDimension && $height <= $maxDimension) {
            return $image;
        }

        if ($width >= $height) {
            $newWidth = $maxDimension;
            $newHeight = (int) round($height * ($maxDimension / $width));
        } else {
            $newHeight = $maxDimension;
            $newWidth = (int) round($width * ($maxDimension / $height));
        }

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);

        return $resized;
    }

    /**
     * JPEG tidak mendukung transparansi; ratakan ke latar putih agar
     * gambar PNG/GIF transparan tidak berubah jadi hitam saat dikonversi.
     */
    private static function flattenToWhite(GdImage $image): GdImage
    {
        $width = imagesx($image);
        $height = imagesy($image);

        $flat = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($flat, 255, 255, 255);
        imagefill($flat, 0, 0, $white);
        imagecopy($flat, $image, 0, 0, 0, 0, $width, $height);
        imagedestroy($image);

        return $flat;
    }
}
