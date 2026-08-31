@extends('layouts.app')

@section('title', 'Label Surat')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari no. label...">
            <button class="btn btn-sm btn-outline-secondary"><x-heroicon-o-magnifying-glass /></button>
        </form>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="check-all">
            <label class="form-check-label small" for="check-all">Pilih Semua</label>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-sm btn-primary" id="btn-cetak" disabled>
                <x-heroicon-o-printer /> Cetak Label Terpilih
            </button>
            <button type="button" class="btn btn-sm btn-success" id="btn-tandai" disabled>
                <x-heroicon-o-check-circle /> Tandai Sudah Dicetak
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger" id="btn-hapus-massal" disabled>
                <x-heroicon-o-trash /> Hapus Terpilih
            </button>
        </div>
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

    <form id="bulk-action-form" method="POST" class="d-none">
        @csrf
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('check-all');
        const rowChecks = document.querySelectorAll('.row-check');
        const btnCetak = document.getElementById('btn-cetak');
        const btnTandai = document.getElementById('btn-tandai');
        const btnHapusMassal = document.getElementById('btn-hapus-massal');
        const bulkForm = document.getElementById('bulk-action-form');

        function checkedIds() {
            return [...rowChecks].filter(c => c.checked).map(c => c.value);
        }

        function updateButtons() {
            const hasChecked = checkedIds().length > 0;
            btnCetak.disabled = !hasChecked;
            btnTandai.disabled = !hasChecked;
            btnHapusMassal.disabled = !hasChecked;
        }

        checkAll?.addEventListener('change', function () {
            rowChecks.forEach(c => c.checked = checkAll.checked);
            updateButtons();
        });

        rowChecks.forEach(c => c.addEventListener('change', updateButtons));

        btnCetak.addEventListener('click', function () {
            const ids = checkedIds();
            if (ids.length === 0) return;
            window.open(`{{ route('admin.surat.cetak') }}?ids=${ids.join(',')}`, '_blank');
        });

        function submitBulk(url, confirmMessage) {
            const ids = checkedIds();
            if (ids.length === 0) return;
            if (!confirm(confirmMessage.replace('__COUNT__', ids.length))) return;

            bulkForm.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());
            ids.forEach(function (id) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                bulkForm.appendChild(input);
            });

            bulkForm.action = url;
            bulkForm.submit();
        }

        btnTandai.addEventListener('click', function () {
            submitBulk(
                '{{ route('admin.surat.tandai-cetak') }}',
                'Tandai __COUNT__ label surat terpilih sebagai sudah dicetak?'
            );
        });

        btnHapusMassal.addEventListener('click', function () {
            submitBulk(
                '{{ route('admin.surat.bulk-destroy') }}',
                'Hapus __COUNT__ surat terpilih beserta seluruh foto barang buktinya? Tindakan ini tidak dapat dibatalkan.'
            );
        });
    });
</script>
@endpush
