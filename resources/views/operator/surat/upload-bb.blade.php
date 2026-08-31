@extends('layouts.app')

@section('title', 'Upload Barang Bukti - '.$surat->no_surat)

@section('content')
    <div class="soft-card mb-3">
        <div class="p-3 p-lg-4">
            <h6 class="mb-1">No. Label: {{ $surat->no_surat }}</h6>
            <div class="text-muted small">Tersangka: {{ $surat->tersangka }}</div>

            <form method="POST" action="{{ route('operator.foto-bb.store', $surat) }}" enctype="multipart/form-data" class="mt-3">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih Foto Barang Bukti (bisa lebih dari satu)</label>
                    <input type="file" name="foto[]" class="form-control" accept="image/*" multiple required>
                </div>
                <button class="btn btn-primary btn-sm"><x-heroicon-o-arrow-up-tray /> Unggah</button>
            </form>
        </div>
    </div>

    <div class="row g-2 g-lg-3">
        @forelse ($surat->fotoBb as $foto)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="soft-card overflow-hidden">
                    <img src="{{ $foto->fotoUrl() }}" class="foto-bb-thumb">
                    <div class="p-2 text-end">
                        <form action="{{ route('operator.foto-bb.destroy', $foto) }}" method="POST" onsubmit="return confirm('Hapus foto ini?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger btn-icon"><x-heroicon-o-trash /></button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada foto barang bukti yang diunggah.</p>
        @endforelse
    </div>

    <div class="mt-4 d-flex flex-wrap gap-2">
        <a href="{{ route('operator.surat.index') }}" class="btn btn-outline-secondary">Kembali ke Daftar</a>
        <form action="{{ route('operator.surat.kirim', $surat) }}" method="POST" onsubmit="return confirm('Kirim label surat ini ke admin? Setelah dikirim, data tidak bisa diubah lagi.');">
            @csrf
            <button class="btn btn-success"><x-heroicon-o-paper-airplane /> Kirim ke Admin</button>
        </form>
    </div>
@endsection
