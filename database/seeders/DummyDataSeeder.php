<?php

namespace Database\Seeders;

use App\Models\BarangBukti;
use App\Models\PenanggungJawab;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    /**
     * Data uji: master barang bukti & penanggung jawab, plus 100 surat riwayat
     * (status selesai) tersebar di berbagai bulan tahun 2026 — untuk mencoba
     * pagination & pencarian riwayat surat.
     *
     * Jalankan manual: php artisan db:seed --class=DummyDataSeeder
     */
    public function run(): void
    {
        $barangBuktiNama = [
            'Metamfetamina (Sabu)', 'Ganja Kering', 'Ekstasi', 'Tembakau Gorila',
            'Plastik Klip Bening', 'Bong/Alat Hisap', 'Timbangan Digital', 'Pipet Kaca',
        ];
        $barangBuktiList = collect($barangBuktiNama)->map(
            fn ($nama) => BarangBukti::firstOrCreate(['nama' => $nama])
        );

        $penanggungJawabData = [
            ['nama' => 'Dr. SUPIYANI, M.Si', 'nrp' => '198010232008012001', 'jabatan' => 'PEMBINA NIP'],
            ['nama' => 'HUSNAH SARI M.TANJUNG, S.Pd', 'nrp' => '197804212003122005', 'jabatan' => 'PENATA TK I NIP'],
            ['nama' => 'R FANI MIRANDA, ST., M.Si', 'nrp' => '92020450', 'jabatan' => 'AKP NRP'],
            ['nama' => 'ANDI WIJAYA, S.H.', 'nrp' => '198505152010011003', 'jabatan' => 'IPTU NRP'],
            ['nama' => 'SITI RAHAYU, S.Si', 'nrp' => '199001202015022001', 'jabatan' => 'PENATA MUDA NIP'],
        ];
        $penanggungJawabList = collect($penanggungJawabData)->map(function ($pj) {
            return PenanggungJawab::firstOrCreate(
                ['nrp' => $pj['nrp']],
                ['nama' => $pj['nama'], 'jabatan' => $pj['jabatan'], 'ttd' => $this->dummyTtdFilename($pj['nama'])]
            );
        });

        $adminId = User::where('role', User::ROLE_ADMIN)->value('id');
        $kotaAsal = ['KAPOLRES ASAHAN', 'KAPOLRES TAPANULI TENGAH', 'POLRESTA MEDAN', 'POLRES DELI SERDANG', 'DIREKTUR RESERSE NARKOBA POLDA SUMUT', 'POLRES LANGKAT', 'POLRES SIMALUNGUN'];

        for ($i = 1; $i <= 100; $i++) {
            $bulan = fake()->numberBetween(1, 12);
            $tanggal = fake()->numberBetween(1, 28);

            Surat::create([
                'no_surat' => sprintf('%04d/NNF/2026', 1000 + $i),
                'id_bb' => $barangBuktiList->random()->id_bb,
                'id_pj' => $penanggungJawabList->random()->id_pj,
                'tgl_surat' => Carbon::create(2026, $bulan, $tanggal),
                'tersangka' => strtoupper(fake()->name()),
                'lokasi_penangkapan' => fake()->randomElement($kotaAsal),
                'waktu_penangkapan' => sprintf('%02d:%02d:00', fake()->numberBetween(0, 23), fake()->numberBetween(0, 59)),
                'status' => Surat::STATUS_SELESAI,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ]);
        }

        $this->command?->info('Berhasil membuat 100 data dummy surat (riwayat).');
    }

    private function dummyTtdFilename(string $nama): string
    {
        $filename = Str::slug($nama).'-'.Str::random(6).'.png';

        $image = imagecreatetruecolor(160, 60);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 20, 20, 20);
        imagefill($image, 0, 0, $white);
        imagestring($image, 4, 10, 20, 'ttd', $black);

        ob_start();
        imagepng($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        Storage::disk('public')->put('ttd/'.$filename, $contents);

        return $filename;
    }
}
