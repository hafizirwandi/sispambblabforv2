@extends('layouts.app')

@section('title', 'Tambah Barang Bukti')

@section('content')
    <div class="soft-card" style="max-width: 500px;">
        <div class="p-4">
            <form method="POST" action="{{ route('admin.barang-bukti.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Barang Bukti</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required autofocus>
                </div>
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.barang-bukti.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
