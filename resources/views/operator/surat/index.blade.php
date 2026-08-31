@extends('layouts.app')

@section('title', 'Label Surat Saya')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari no. label...">
            <button class="btn btn-sm btn-outline-secondary"><x-heroicon-o-magnifying-glass /></button>
        </form>
        <a href="{{ route('operator.surat.create') }}" class="btn btn-primary btn-sm">
            <x-heroicon-o-plus class="me-1" /> Input Label Baru
        </a>
    </div>

    <div class="data-list">
        @forelse ($surat as $item)
            <div class="data-row">
                <div class="data-row-main">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="data-row-title">{{ $item->no_surat }}</span>
                        <x-status-badge :status="$item->status" />
                    </div>
                    <div class="data-row-meta">
                        <span>{{ $item->foto_bb_count }} foto barang bukti</span>
                    </div>
                </div>
                <div class="data-row-actions">
                    @if($item->status === \App\Models\Surat::STATUS_DRAFT)
                        <a href="{{ route('operator.foto-bb.index', $item) }}" class="btn btn-sm btn-outline-secondary">
                            <x-heroicon-o-photo /> <span class="d-none d-sm-inline">Upload BB</span>
                        </a>
                        <a href="{{ route('operator.surat.edit', $item) }}" class="btn btn-sm btn-outline-primary btn-icon">
                            <x-heroicon-o-pencil-square />
                        </a>
                        <form action="{{ route('operator.surat.kirim', $item) }}" method="POST" onsubmit="return confirm('Kirim label surat ini ke admin? Setelah dikirim, data tidak bisa diubah lagi.');">
                            @csrf
                            <button class="btn btn-sm btn-success"><x-heroicon-o-paper-airplane /> <span class="d-none d-sm-inline">Kirim</span></button>
                        </form>
                    @else
                        <a href="{{ route('operator.surat.show', $item) }}" class="btn btn-sm btn-outline-secondary">
                            <x-heroicon-o-eye /> <span class="d-none d-sm-inline">Lihat</span>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="data-row-empty">Belum ada data.</div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $surat->links() }}
    </div>
@endsection
