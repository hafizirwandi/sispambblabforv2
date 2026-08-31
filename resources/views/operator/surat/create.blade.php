@extends('layouts.app')

@section('title', 'Input Label Surat Baru')

@section('content')
    <div class="soft-card" style="max-width: 500px;">
        <div class="p-4">
            <p class="text-muted small">Masukkan nomor label, lalu unggah foto barang bukti. Detail lainnya (barang bukti, tersangka, penanggung jawab, dll) akan dilengkapi oleh admin.</p>
            <form method="POST" action="{{ route('operator.surat.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">No. Label / No. Surat</label>
                    <input type="text" name="no_surat" class="form-control" value="{{ old('no_surat') }}" required autofocus>
                </div>
                <button class="btn btn-primary">Simpan &amp; Lanjut Upload BB</button>
                <a href="{{ route('operator.surat.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
