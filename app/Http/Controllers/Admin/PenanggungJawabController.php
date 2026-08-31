<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenanggungJawab;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PenanggungJawabController extends Controller
{
    public function index(Request $request): View
    {
        $penanggungJawab = PenanggungJawab::query()
            ->when($request->filled('q'), fn ($q) => $q->where('nama', 'like', '%'.$request->string('q').'%'))
            ->orderByDesc('id_pj')
            ->paginate(15)
            ->withQueryString();

        return view('admin.penanggung-jawab.index', compact('penanggungJawab'));
    }

    public function create(): View
    {
        return view('admin.penanggung-jawab.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $data['ttd'] = $this->storeTtd($request);

        PenanggungJawab::create($data);

        return redirect()->route('admin.penanggung-jawab.index')->with('success', 'Penanggung jawab berhasil ditambahkan.');
    }

    public function edit(PenanggungJawab $penanggungJawab): View
    {
        return view('admin.penanggung-jawab.edit', compact('penanggungJawab'));
    }

    public function update(Request $request, PenanggungJawab $penanggungJawab): RedirectResponse
    {
        $data = $this->validated($request, $penanggungJawab->id_pj);

        if ($request->hasFile('ttd')) {
            if ($penanggungJawab->ttd) {
                Storage::disk('public')->delete('ttd/'.$penanggungJawab->ttd);
            }
            $data['ttd'] = $this->storeTtd($request);
        }

        $penanggungJawab->update($data);

        return redirect()->route('admin.penanggung-jawab.index')->with('success', 'Penanggung jawab berhasil diperbarui.');
    }

    public function destroy(PenanggungJawab $penanggungJawab): RedirectResponse
    {
        if ($penanggungJawab->surat()->exists()) {
            return back()->with('error', 'Penanggung jawab tidak bisa dihapus karena masih dipakai pada label surat.');
        }

        if ($penanggungJawab->ttd) {
            Storage::disk('public')->delete('ttd/'.$penanggungJawab->ttd);
        }

        $penanggungJawab->delete();

        return redirect()->route('admin.penanggung-jawab.index')->with('success', 'Penanggung jawab berhasil dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:225'],
            'nrp' => ['required', 'string', 'max:225'],
            'jabatan' => ['required', 'string', 'max:225'],
            'ttd' => [$ignoreId ? 'nullable' : 'required', 'file', 'image', 'max:2048'],
        ]);
    }

    private function storeTtd(Request $request): string
    {
        $file = $request->file('ttd');
        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->storeAs('ttd', $filename, 'public');

        return $filename;
    }
}
