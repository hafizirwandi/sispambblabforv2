<?php

namespace Database\Seeders;

use App\Models\FotoBb;
use App\Support\ImageCompressor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ResizeFotoBbSeeder extends Seeder
{
    private const MAX_DIMENSION = 800;

    private const QUALITY = 80;

    /**
     * Resize + kompres ulang foto barang bukti yang sudah ada di storage
     * (foto lama, sebelum fitur kompresi otomatis ada saat upload).
     *
     * Jalankan manual: php artisan db:seed --class=ResizeFotoBbSeeder
     */
    public function run(): void
    {
        $resized = 0;
        $skippedMissing = 0;
        $alreadyFine = 0;

        FotoBb::orderBy('id_fb')->chunk(50, function ($chunk) use (&$resized, &$skippedMissing, &$alreadyFine) {
            foreach ($chunk as $foto) {
                if (! Storage::disk('public')->exists('foto_bb/'.$foto->foto)) {
                    $skippedMissing++;

                    continue;
                }

                $newFilename = ImageCompressor::resizeStoredFile(
                    'public',
                    'foto_bb',
                    $foto->foto,
                    self::MAX_DIMENSION,
                    self::QUALITY
                );

                if ($newFilename === $foto->foto) {
                    $alreadyFine++;

                    continue;
                }

                $foto->foto = $newFilename;
                $foto->saveQuietly();
                $resized++;
            }
        });

        $this->command?->info(
            "Selesai: {$resized} foto di-resize & dikompres, {$alreadyFine} sudah pas (dilewati), {$skippedMissing} file tidak ditemukan di storage."
        );
    }
}
