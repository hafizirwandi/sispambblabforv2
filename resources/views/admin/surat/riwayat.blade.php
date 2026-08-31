@extends('layouts.app')

@section('title', 'Riwayat Surat')

@section('content')
    <div class="soft-card mb-3">
        <div class="p-3 p-lg-4">
            <form method="GET" id="riwayat-form" class="row g-2 align-items-end">
                <div class="col-12 col-md-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label small fw-semibold mb-0">No. Label</label>
                        @if(request('label'))
                            <button type="button" class="btn btn-link btn-sm p-0 text-muted field-reset" data-target="field-label" title="Hapus filter ini">
                                <x-heroicon-o-x-mark style="width:14px;height:14px;" /> Reset
                            </button>
                        @endif
                    </div>
                    <input type="text" name="label" id="field-label" value="{{ request('label') }}" class="form-control" placeholder="Cari no. label...">
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label small fw-semibold mb-0">Tanggal</label>
                        @if(request('date'))
                            <button type="button" class="btn btn-link btn-sm p-0 text-muted field-reset" data-target="field-date" title="Hapus filter ini">
                                <x-heroicon-o-x-mark style="width:14px;height:14px;" />
                            </button>
                        @endif
                    </div>
                    <input type="date" name="date" id="field-date" value="{{ request('date') }}" class="form-control">
                </div>
                <div class="col-6 col-md-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label small fw-semibold mb-0">Bulan</label>
                        @if(request('month'))
                            <button type="button" class="btn btn-link btn-sm p-0 text-muted field-reset" data-target="field-month" title="Hapus filter ini">
                                <x-heroicon-o-x-mark style="width:14px;height:14px;" />
                            </button>
                        @endif
                    </div>
                    <select name="month" id="field-month" class="form-select">
                        <option value="">Semua</option>
                        @foreach (range(1, 12) as $m)
                            <option value="{{ $m }}" @selected(request('month') == $m)>{{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label small fw-semibold mb-0">Tahun</label>
                        @if(request('year'))
                            <button type="button" class="btn btn-link btn-sm p-0 text-muted field-reset" data-target="field-year" title="Hapus filter ini">
                                <x-heroicon-o-x-mark style="width:14px;height:14px;" />
                            </button>
                        @endif
                    </div>
                    <select name="year" id="field-year" class="form-select">
                        <option value="">Semua</option>
                        @foreach (range(now()->year, now()->year - 5) as $y)
                            <option value="{{ $y }}" @selected(request('year') == $y)>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-1 d-grid">
                    <button class="btn btn-primary"><x-heroicon-o-magnifying-glass /></button>
                </div>
            </form>

            @if ($hasSearch)
                <div class="mt-2">
                    <a href="{{ route('admin.surat.riwayat') }}" class="btn btn-sm btn-outline-secondary">
                        <x-heroicon-o-arrow-path class="me-1" /> Reset Semua Filter
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if (!$hasSearch)
        <div class="data-row-empty">
            <x-heroicon-o-magnifying-glass class="fs-3 mb-2 d-block mx-auto text-muted" />
            Gunakan pencarian di atas (no. label, tanggal, bulan, atau tahun) untuk menampilkan riwayat surat yang sudah selesai/dicetak.
        </div>
    @else
        <div class="data-list">
            @forelse ($suratRiwayat as $item)
                <div class="data-row">
                    <div class="data-row-main">
                        <div class="data-row-title">{{ $item->no_surat }}</div>
                        <div class="data-row-meta">
                            <span>{{ $item->tersangka !== '' ? $item->tersangka : '-' }}</span>
                            <span>{{ $item->barangBukti?->nama ?? '-' }}</span>
                            <span>{{ $item->penanggungJawab?->nama ?? '-' }}</span>
                            <span>{{ $item->tgl_surat->format('d-m-Y') }}</span>
                        </div>
                    </div>
                    <div class="data-row-actions">
                        <a href="{{ route('lampiran.show', $item) }}" target="_blank" class="btn btn-sm btn-outline-secondary btn-icon" title="Detail Lampiran">
                            <x-heroicon-o-photo />
                        </a>
                        <a href="{{ route('admin.surat.cetak') }}?ids={{ $item->id_surat }}" target="_blank" class="btn btn-sm btn-outline-secondary btn-icon" title="Cetak Ulang Label">
                            <x-heroicon-o-printer />
                        </a>
                    </div>
                </div>
            @empty
                <div class="data-row-empty">Tidak ada riwayat surat yang cocok dengan pencarian.</div>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $suratRiwayat->links() }}
        </div>
    @endif
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.field-reset').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const field = document.getElementById(btn.dataset.target);
            field.value = '';
            document.getElementById('riwayat-form').submit();
        });
    });
</script>
@endpush
