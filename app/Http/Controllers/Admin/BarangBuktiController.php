<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangBukti;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangBuktiController extends Controller
{
    public function index(Request $request): View
    {
        $barangBukti = BarangBukti::query()
            ->when($request->filled('q'), fn ($q) => $q->where('nama', 'like', '%'.$request->string('q').'%'))
            ->orderByDesc('id_bb')
            ->paginate(15)
            ->withQueryString();

        return view('admin.barang-bukti.index', compact('barangBukti'));
    }

    public function create(): View
    {
        return view('admin.barang-bukti.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:225'],
        ]);

        BarangBukti::create($data);

        return redirect()->route('admin.barang-bukti.index')->with('success', 'Barang bukti berhasil ditambahkan.');
    }

    public function edit(BarangBukti $barangBukti): View
    {
        return view('admin.barang-bukti.edit', compact('barangBukti'));
    }

    public function update(Request $request, BarangBukti $barangBukti): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:225'],
        ]);

        $barangBukti->update($data);

        return redirect()->route('admin.barang-bukti.index')->with('success', 'Barang bukti berhasil diperbarui.');
    }

    public function destroy(BarangBukti $barangBukti): RedirectResponse
    {
        if ($barangBukti->surat()->exists()) {
            return back()->with('error', 'Barang bukti tidak bisa dihapus karena masih dipakai pada label surat.');
        }

        $barangBukti->delete();

        return redirect()->route('admin.barang-bukti.index')->with('success', 'Barang bukti berhasil dihapus.');
    }
}
