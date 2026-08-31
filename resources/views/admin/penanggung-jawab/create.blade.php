@extends('layouts.app')

@section('title', 'Tambah Penanggung Jawab')

@section('content')
    <div class="soft-card" style="max-width: 500px;">
        <div class="p-4">
            <form method="POST" action="{{ route('admin.penanggung-jawab.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">NRP</label>
                    <input type="text" name="nrp" class="form-control" value="{{ old('nrp') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" placeholder="mis. PEMBINA NIP / AKP NRP" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanda Tangan (TTD)</label>
                    <input type="file" name="ttd" class="form-control" accept="image/*" required>
                </div>
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.penanggung-jawab.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
