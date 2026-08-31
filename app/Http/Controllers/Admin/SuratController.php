<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangBukti;
use App\Models\PenanggungJawab;
use App\Models\Surat;
use App\Services\SuratService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratController extends Controller
{
    public function __construct(private readonly SuratService $suratService)
    {
    }

    public function index(Request $request): View
    {
        $surat = Surat::query()
            ->with(['barangBukti', 'penanggungJawab'])
            ->where('status', Surat::STATUS_TERKIRIM)
            ->when($request->filled('q'), fn ($q) => $q->where('no_surat', 'like', '%'.$request->string('q').'%'))
            ->orderByDesc('id_surat')
            ->paginate(15)
            ->withQueryString();

        return view('admin.surat.index', compact('surat'));
    }

    public function edit(Surat $surat): View
    {
        $surat->load('fotoBb');
        $barangBukti = BarangBukti::orderBy('nama')->get();
        $penanggungJawab = PenanggungJawab::orderBy('nama')->get();

        return view('admin.surat.edit', compact('surat', 'barangBukti', 'penanggungJawab'));
    }

    public function update(Request $request, Surat $surat): RedirectResponse
    {
        $data = $request->validate([
            'no_surat' => ['required', 'string', 'max:225'],
            'id_bb' => ['required', 'integer', 'exists:barang_bukti,id_bb'],
            'id_pj' => ['required', 'integer', 'exists:penanggung_jawab,id_pj'],
            'tgl_surat' => ['required', 'date'],
            'tersangka' => ['required', 'string', 'max:225'],
            'lokasi_penangkapan' => ['required', 'string', 'max:225'],
            'waktu_penangkapan' => ['required'],
        ]);

        $surat->update($data);

        return redirect()->route('admin.surat.index')->with('success', 'Data surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat): RedirectResponse
    {
        $this->suratService->deleteWithAttachments($surat);

        return redirect()->route('admin.surat.index')->with('success', 'Surat dan barang bukti terkait berhasil dihapus.');
    }

    public function riwayat(Request $request): View
    {
        $hasSearch = $request->filled('label') || $request->filled('date') || $request->filled('month') || $request->filled('year');

        $suratRiwayat = null;

        if ($hasSearch) {
            $suratRiwayat = Surat::query()
                ->with(['barangBukti', 'penanggungJawab'])
                ->where('status', Surat::STATUS_SELESAI)
                ->when($request->filled('label'), fn ($q) => $q->where('no_surat', 'like', '%'.$request->string('label').'%'))
                ->when($request->filled('date'), fn ($q) => $q->whereDate('tgl_surat', $request->date('date')))
                ->when($request->filled('month'), fn ($q) => $q->whereMonth('tgl_surat', (int) $request->input('month')))
                ->when($request->filled('year'), fn ($q) => $q->whereYear('tgl_surat', (int) $request->input('year')))
                ->orderByDesc('tgl_surat')
                ->paginate(15)
                ->withQueryString();
        }

        return view('admin.surat.riwayat', compact('suratRiwayat', 'hasSearch'));
    }

    public function cetak(Request $request): View
    {
        $ids = collect(explode(',', (string) $request->query('ids')))
            ->map(fn ($id) => (int) trim($id))
            ->filter()
            ->values();

        abort_if($ids->isEmpty(), 404, 'Tidak ada label surat yang dipilih untuk dicetak.');

        $suratList = Surat::with(['barangBukti', 'penanggungJawab'])
            ->whereIn('id_surat', $ids)
            ->orderByRaw('FIELD(id_surat, '.$ids->implode(',').')')
            ->get();

        return view('admin.surat.cetak', compact('suratList'));
    }
}
