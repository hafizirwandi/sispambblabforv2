@extends('layouts.app')

@section('title', 'Ubah Penanggung Jawab')

@section('content')
    <div class="soft-card" style="max-width: 500px;">
        <div class="p-4">
            <form method="POST" action="{{ route('admin.penanggung-jawab.update', $penanggungJawab) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $penanggungJawab->nama) }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">NRP</label>
                    <input type="text" name="nrp" class="form-control" value="{{ old('nrp', $penanggungJawab->nrp) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $penanggungJawab->jabatan) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanda Tangan (TTD)</label><br>
                    @if($penanggungJawab->ttdUrl())
                        <img src="{{ $penanggungJawab->ttdUrl() }}" class="ttd-thumb mb-2" alt="TTD saat ini"><br>
                    @endif
                    <input type="file" name="ttd" class="form-control" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti TTD.</small>
                </div>
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.penanggung-jawab.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
