<?php

namespace App\Services;

use App\Models\Surat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratService
{
    /**
     * Hapus surat beserta seluruh foto_bb terkait, termasuk file fisiknya di storage.
     */
    public function deleteWithAttachments(Surat $surat): void
    {
        DB::transaction(function () use ($surat) {
            foreach ($surat->fotoBb as $foto) {
                Storage::disk('public')->delete('foto_bb/'.$foto->foto);
                $foto->delete();
            }

            $surat->delete();
        });
    }

    /**
     * Hapus semua surat (+ foto_bb & file) yang tgl_surat berada dalam rentang bulan/tahun tertentu (inklusif).
     */
    public function deleteByPeriod(string $fromDate, string $toDate): int
    {
        $suratList = Surat::whereBetween('tgl_surat', [$fromDate, $toDate])->get();

        foreach ($suratList as $surat) {
            $this->deleteWithAttachments($surat);
        }

        return $suratList->count();
    }

    public function countByPeriod(string $fromDate, string $toDate): array
    {
        $suratQuery = Surat::whereBetween('tgl_surat', [$fromDate, $toDate]);

        return [
            'surat' => (clone $suratQuery)->count(),
            'foto_bb' => \App\Models\FotoBb::whereIn('id_surat', (clone $suratQuery)->pluck('id_surat'))->count(),
        ];
    }
}
