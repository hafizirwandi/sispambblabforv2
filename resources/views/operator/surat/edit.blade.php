@extends('layouts.app')

@section('title', 'Ubah Nomor Label')

@section('content')
    <div class="soft-card" style="max-width: 500px;">
        <div class="p-4">
            <form method="POST" action="{{ route('operator.surat.update', $surat) }}">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">No. Label / No. Surat</label>
                    <input type="text" name="no_surat" class="form-control" value="{{ old('no_surat', $surat->no_surat) }}" required autofocus>
                </div>
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('operator.foto-bb.index', $surat) }}" class="btn btn-outline-secondary">Upload BB</a>
                <a href="{{ route('operator.surat.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
