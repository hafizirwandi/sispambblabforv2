<?php

namespace Database\Seeders;

use App\Models\Surat;
use Illuminate\Database\Seeder;

class LegacySuratStatusSeeder extends Seeder
{
    /**
     * Backfill satu kali: label surat lama yang masih berstatus "terkirim" (1) tapi
     * tanggal suratnya sebelum Agustus 2026 dianggap sudah selesai diproses sebelum
     * rewrite ini, sehingga tidak memenuhi antrian admin.
     *
     * Jalankan manual: php artisan db:seed --class=LegacySuratStatusSeeder
     */
    public function run(): void
    {
        $updated = Surat::where('status', Surat::STATUS_TERKIRIM)
            ->where('tgl_surat', '<', '2026-08-01')
            ->update(['status' => Surat::STATUS_SELESAI]);

        $this->command?->info("Berhasil memperbarui status {$updated} surat lama menjadi selesai.");
    }
}
