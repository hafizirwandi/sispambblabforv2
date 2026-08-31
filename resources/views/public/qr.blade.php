<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Label - SISPAMBBLABFOR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-3" style="min-height: 100vh; background: var(--sispam-bg);">
    <div class="soft-card mx-auto" style="width: 100%; max-width: 480px;">
        <div class="p-4">
            <div class="text-center mb-3">
                <span class="d-inline-flex align-items-center justify-content-center mb-2" style="width:56px;height:56px;border-radius:16px;background:var(--sispam-success-soft);color:var(--sispam-success);font-size:1.6rem;">
                    <x-heroicon-s-check-badge />
                </span>
                <h6 class="mt-1 mb-0">Label Barang Bukti Terverifikasi</h6>
                <small class="text-muted">Bidang Laboratorium Forensik Polda Sumut</small>
            </div>

            <div class="text-center mb-3">
                <div class="text-muted small">No. LAB</div>
                <div class="fs-5 fw-bold">{{ $surat->no_surat }}</div>
            </div>

            <div class="row g-2">
                @forelse ($surat->fotoBb as $foto)
                    <div class="col-6">
                        <a href="{{ $foto->fotoUrl() }}" target="_blank">
                            <img src="{{ $foto->fotoUrl() }}" class="foto-bb-thumb">
                        </a>
                    </div>
                @empty
                    <p class="text-muted small text-center mb-0">Belum ada foto barang bukti.</p>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>
