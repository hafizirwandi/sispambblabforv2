@extends('layouts.print')

@section('title', 'Lampiran '.$surat->no_surat)

@section('content')
    <div class="lampiran-page">
        <div class="lampiran-header">
            Lampiran {{ $surat->no_surat }}
        </div>

        @forelse ($surat->fotoBb as $foto)
            <div class="lampiran-foto-block" style="{{ $loop->iteration % 2 === 0 && !$loop->last ? 'page-break-after: always;' : '' }}">
                <img src="{{ $foto->fotoUrl() }}" alt="Foto barang bukti {{ $surat->no_surat }}">
            </div>
        @empty
            <p class="text-muted text-center">Belum ada foto barang bukti untuk surat ini.</p>
        @endforelse
    </div>
@endsection
