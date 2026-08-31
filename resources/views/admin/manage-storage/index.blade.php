@extends('layouts.app')

@section('title', 'Manage Storage')

@section('content')
    <div class="soft-card" style="max-width: 650px;">
        <div class="p-4">
            <p class="text-muted small">
                Fitur ini menghapus <strong>permanen</strong> seluruh data surat beserta foto barang bukti
                (termasuk file di storage) pada rentang bulan/tahun yang dipilih. Gunakan dengan hati-hati.
            </p>

            <form id="storage-form" method="POST" action="{{ route('admin.manage-storage.destroy') }}">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Dari</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <select name="from_month" class="form-select" required>
                                    @foreach (range(1,12) as $m)
                                        <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="number" name="from_year" class="form-control" value="{{ now()->year }}" min="2000" max="2100" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Sampai</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <select name="to_month" class="form-select" required>
                                    @foreach (range(1,12) as $m)
                                        <option value="{{ $m }}" @selected($m == now()->month)>{{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="number" name="to_year" class="form-control" value="{{ now()->year }}" min="2000" max="2100" required>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="btn-preview" class="btn btn-outline-primary mt-4">
                    <x-heroicon-o-magnifying-glass /> Proses / Cek Jumlah Data
                </button>
            </form>

            <div id="preview-result" class="alert alert-warning mt-3 d-none"></div>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="confirmModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btn-confirm-delete" class="btn btn-danger">Ya, Hapus Permanen</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('storage-form');
        const previewBox = document.getElementById('preview-result');
        const modalEl = document.getElementById('confirmModal');
        const modal = new bootstrap.Modal(modalEl);

        document.getElementById('btn-preview').addEventListener('click', async function () {
            const formData = new FormData(form);
            const res = await fetch(@json(route('admin.manage-storage.preview')), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': @json(csrf_token()), 'Accept': 'application/json' },
                body: formData,
            });

            if (!res.ok) {
                previewBox.classList.remove('d-none');
                previewBox.textContent = 'Periode tidak valid.';
                return;
            }

            const data = await res.json();
            previewBox.classList.remove('d-none');
            previewBox.innerHTML = `Ditemukan <strong>${data.surat}</strong> surat dan <strong>${data.foto_bb}</strong> foto barang bukti pada periode ini.`;

            document.getElementById('confirmModalBody').innerHTML =
                `Anda akan menghapus permanen <strong>${data.surat}</strong> surat beserta <strong>${data.foto_bb}</strong> foto barang bukti (termasuk file di storage). Tindakan ini tidak dapat dibatalkan. Yakin ingin melanjutkan?`;

            if (data.surat > 0) {
                modal.show();
            }
        });

        document.getElementById('btn-confirm-delete').addEventListener('click', function () {
            form.submit();
        });
    });
</script>
@endpush
