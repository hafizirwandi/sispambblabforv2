<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Label - SISPAMBBLABFOR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex align-items-center justify-content-center p-3" style="min-height: 100vh; background: var(--sispam-bg);">
    <div class="soft-card" style="width: 100%; max-width: 420px;">
        <div class="p-4">
            <div class="text-center mb-3">
                <span class="d-inline-flex align-items-center justify-content-center mb-2" style="width:56px;height:56px;border-radius:16px;background:var(--sispam-success-soft);color:var(--sispam-success);font-size:1.6rem;">
                    <x-heroicon-s-check-badge />
                </span>
                <h6 class="mt-1 mb-0">Label Barang Bukti Terverifikasi</h6>
                <small class="text-muted">Bidang Laboratorium Forensik Polda Sumut</small>
            </div>

            <dl class="row mb-0 small">
                <dt class="col-5 col-sm-4 text-muted fw-normal">No. LAB</dt>
                <dd class="col-7 col-sm-8">{{ $surat->no_surat }}</dd>

                <dt class="col-5 col-sm-4 text-muted fw-normal">Barang Bukti</dt>
                <dd class="col-7 col-sm-8">{{ $surat->barangBukti?->nama }}</dd>

                <dt class="col-5 col-sm-4 text-muted fw-normal">Tersangka</dt>
                <dd class="col-7 col-sm-8 fw-semibold">{{ $surat->tersangka }}</dd>

                <dt class="col-5 col-sm-4 text-muted fw-normal">Berasal Dari</dt>
                <dd class="col-7 col-sm-8">{{ $surat->lokasi_penangkapan }}</dd>

                <dt class="col-5 col-sm-4 text-muted fw-normal">Tanggal Surat</dt>
                <dd class="col-7 col-sm-8">{{ $surat->tglSuratFormatted() }}</dd>

                <dt class="col-5 col-sm-4 text-muted fw-normal">Penanggung Jawab</dt>
                <dd class="col-7 col-sm-8 mb-0">{{ $surat->penanggungJawab?->nama }}<br><span class="text-muted">{{ $surat->penanggungJawab?->jabatan }} {{ $surat->penanggungJawab?->nrp }}</span></dd>
            </dl>
        </div>
    </div>
</body>
</html>
