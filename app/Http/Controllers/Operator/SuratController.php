<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SuratController extends Controller
{
    /**
     * Nilai default untuk kolom yang wajib diisi (NOT NULL) di skema `surat`,
     * tapi belum diketahui operator saat menginput label. Admin melengkapi
     * nilai sebenarnya pada tahap "lengkapi data".
     */
    private const UNSET_REF_ID = 0;

    public function index(Request $request): View
    {
        $surat = Surat::query()
            ->withCount('fotoBb')
            ->where('created_by', Auth::id())
            ->where(function ($q) {
                $q->where('status', Surat::STATUS_DRAFT)
                    ->orWhere('created_at', '>=', Carbon::now()->subWeek());
            })
            ->when($request->filled('q'), fn ($q) => $q->where('no_surat', 'like', '%'.$request->string('q').'%'))
            ->orderByDesc('id_surat')
            ->paginate(15)
            ->withQueryString();

        return view('operator.surat.index', compact('surat'));
    }

    public function show(Surat $surat): View
    {
        abort_if($surat->created_by !== Auth::id() || $surat->status === Surat::STATUS_DRAFT, 403);

        $surat->load(['barangBukti', 'penanggungJawab', 'fotoBb']);

        return view('operator.surat.show', compact('surat'));
    }

    public function create(): View
    {
        return view('operator.surat.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'no_surat' => ['required', 'string', 'max:225'],
        ]);

        $surat = Surat::create($data + [
            'status' => Surat::STATUS_DRAFT,
            'id_bb' => self::UNSET_REF_ID,
            'id_pj' => self::UNSET_REF_ID,
            'tgl_surat' => Carbon::today(),
            'tersangka' => '',
            'lokasi_penangkapan' => '',
            'waktu_penangkapan' => Carbon::now()->format('H:i:s'),
        ]);

        return redirect()->route('operator.foto-bb.index', $surat)
            ->with('success', 'Nomor label berhasil disimpan. Silakan unggah foto barang bukti.');
    }

    public function edit(Surat $surat): View
    {
        $this->authorizeDraft($surat);

        return view('operator.surat.edit', compact('surat'));
    }

    public function update(Request $request, Surat $surat): RedirectResponse
    {
        $this->authorizeDraft($surat);

        $data = $request->validate([
            'no_surat' => ['required', 'string', 'max:225'],
        ]);

        $surat->update($data);

        return redirect()->route('operator.surat.index')->with('success', 'Nomor label berhasil diperbarui.');
    }

    public function kirim(Surat $surat): RedirectResponse
    {
        $this->authorizeDraft($surat);

        if ($surat->fotoBb()->count() === 0) {
            return back()->with('error', 'Unggah minimal satu foto barang bukti sebelum mengirim ke admin.');
        }

        $surat->update(['status' => Surat::STATUS_TERKIRIM]);

        return redirect()->route('operator.surat.index')->with('success', 'Label surat berhasil dikirim ke admin.');
    }

    private function authorizeDraft(Surat $surat): void
    {
        abort_if(
            $surat->created_by !== Auth::id() || $surat->status !== Surat::STATUS_DRAFT,
            403,
            'Label surat ini sudah dikirim ke admin dan tidak bisa diubah lagi.'
        );
    }
}
