@extends('layouts.app')

@section('title', 'Penanggung Jawab / Pemeriksa')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama...">
            <button class="btn btn-sm btn-outline-secondary"><x-heroicon-o-magnifying-glass /></button>
        </form>
        <a href="{{ route('admin.penanggung-jawab.create') }}" class="btn btn-primary btn-sm">
            <x-heroicon-o-plus class="me-1" /> Tambah
        </a>
    </div>

    <div class="data-list">
        @forelse ($penanggungJawab as $item)
            <div class="data-row">
                @if($item->ttdUrl())
                    <img src="{{ $item->ttdUrl() }}" class="ttd-thumb" alt="TTD {{ $item->nama }}">
                @endif
                <div class="data-row-main">
                    <div class="data-row-title">{{ $item->nama }}</div>
                    <div class="data-row-meta">
                        <span>NRP {{ $item->nrp }}</span>
                        <span>{{ $item->jabatan }}</span>
                    </div>
                </div>
                <div class="data-row-actions">
                    <a href="{{ route('admin.penanggung-jawab.edit', $item) }}" class="btn btn-sm btn-outline-primary btn-icon">
                        <x-heroicon-o-pencil-square />
                    </a>
                    <form action="{{ route('admin.penanggung-jawab.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus penanggung jawab ini?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger btn-icon"><x-heroicon-o-trash /></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="data-row-empty">Belum ada data.</div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $penanggungJawab->links() }}
    </div>
@endsection
