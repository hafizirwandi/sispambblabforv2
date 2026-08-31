@extends('layouts.app')

@section('title', 'Label Surat')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari no. label...">
            <button class="btn btn-sm btn-outline-secondary"><x-heroicon-o-magnifying-glass /></button>
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="check-all">
            <label class="form-check-label small" for="check-all">Pilih Semua</label>
        </div>
        <button type="button" class="btn btn-sm btn-primary" id="btn-cetak" disabled>
            <x-heroicon-o-printer /> Cetak Label Terpilih
        </button>
    </div>

    <div class="data-list">
        @forelse ($surat as $item)
            <div class="data-row has-check">
                <input type="checkbox" class="form-check-input row-check flex-shrink-0" value="{{ $item->id_surat }}">
                <div class="data-row-main">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="data-row-title">{{ $item->no_surat }}</span>
                        @unless($item->isDataComplete())
                            <span class="status-pill status-terkirim">Belum dilengkapi</span>
                        @endif
                    </div>
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
                    <a href="{{ route('admin.surat.edit', $item) }}" class="btn btn-sm btn-outline-primary btn-icon" title="Lanjut / Edit">
                        <x-heroicon-o-pencil-square />
                    </a>
                    <form action="{{ route('admin.surat.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus surat ini beserta seluruh foto barang buktinya?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger btn-icon" title="Hapus">
                            <x-heroicon-o-trash />
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="data-row-empty">Tidak ada label surat yang menunggu diproses.</div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $surat->links() }}
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('check-all');
        const rowChecks = document.querySelectorAll('.row-check');
        const btnCetak = document.getElementById('btn-cetak');

        function updateBtn() {
            btnCetak.disabled = ![...rowChecks].some(c => c.checked);
        }

        checkAll?.addEventListener('change', function () {
            rowChecks.forEach(c => c.checked = checkAll.checked);
            updateBtn();
        });

        rowChecks.forEach(c => c.addEventListener('change', updateBtn));

        btnCetak.addEventListener('click', function () {
            const ids = [...rowChecks].filter(c => c.checked).map(c => c.value);
            if (ids.length === 0) return;
            window.open(`{{ route('admin.surat.cetak') }}?ids=${ids.join(',')}`, '_blank');
        });
    });
</script>
@endpush
