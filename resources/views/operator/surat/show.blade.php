@extends('layouts.app')

@section('title', 'Detail Label - '.$surat->no_surat)

@section('content')
    <div class="row g-3">
        <div class="col-md-6">
            <div class="soft-card">
                <div class="p-4">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
                        <h6 class="mb-0">{{ $surat->no_surat }}</h6>
                        <x-status-badge :status="$surat->status" />
                    </div>

                    @unless($surat->isDataComplete())
                        <div class="alert border-0 py-2 small mb-3" style="background-color: var(--sispam-warning-soft); color: var(--sispam-warning);">
                            Data surat ini masih dilengkapi oleh admin.
                        </div>
                    @endunless

                    <dl class="row mb-0 small">
                        <dt class="col-5 text-muted fw-normal">Barang Bukti</dt>
                        <dd class="col-7">{{ $surat->barangBukti?->nama ?? '-' }}</dd>

                        <dt class="col-5 text-muted fw-normal">Tersangka</dt>
                        <dd class="col-7">{{ $surat->tersangka !== '' ? $surat->tersangka : '-' }}</dd>

                        <dt class="col-5 text-muted fw-normal">Berasal Dari</dt>
                        <dd class="col-7">{{ $surat->lokasi_penangkapan !== '' ? $surat->lokasi_penangkapan : '-' }}</dd>

                        <dt class="col-5 text-muted fw-normal">Tanggal Surat</dt>
                        <dd class="col-7">{{ $surat->tgl_surat->format('d-m-Y') }}</dd>

                        <dt class="col-5 text-muted fw-normal">Waktu Penangkapan</dt>
                        <dd class="col-7">{{ $surat->waktu_penangkapan }}</dd>

                        <dt class="col-5 text-muted fw-normal">Penanggung Jawab</dt>
                        <dd class="col-7 mb-0">{{ $surat->penanggungJawab?->nama ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="soft-card">
                <div class="p-4">
                    <h6 class="mb-3">Foto Barang Bukti</h6>
                    <div class="row g-2">
                        @forelse ($surat->fotoBb as $foto)
                            <div class="col-6">
                                <img src="{{ $foto->fotoUrl() }}" class="foto-bb-thumb">
                            </div>
                        @empty
                            <p class="text-muted small">Belum ada foto barang bukti.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('operator.surat.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>
@endsection
