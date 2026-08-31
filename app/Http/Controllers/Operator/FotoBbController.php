<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\FotoBb;
use App\Models\Surat;
use App\Support\ImageCompressor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FotoBbController extends Controller
{
    public function index(Surat $surat): View
    {
        $this->authorizeDraft($surat);

        $surat->load('fotoBb');

        return view('operator.surat.upload-bb', compact('surat'));
    }

    public function store(Request $request, Surat $surat): RedirectResponse
    {
        $this->authorizeDraft($surat);

        $request->validate([
            'foto' => ['required', 'array', 'min:1'],
            // Batas diset longgar (15MB) karena foto akan otomatis di-resize & dikompres saat disimpan.
            'foto.*' => ['file', 'image', 'max:15360'],
        ]);

        foreach ($request->file('foto') as $file) {
            $filename = ImageCompressor::store($file, 'public', 'foto_bb');

            FotoBb::create([
                'id_surat' => $surat->id_surat,
                'foto' => $filename,
            ]);
        }

        return back()->with('success', 'Foto barang bukti berhasil diunggah.');
    }

    public function destroy(FotoBb $fotoBb): RedirectResponse
    {
        $this->authorizeDraft($fotoBb->surat);

        Storage::disk('public')->delete('foto_bb/'.$fotoBb->foto);
        $fotoBb->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
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
