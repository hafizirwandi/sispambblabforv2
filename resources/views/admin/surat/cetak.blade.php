@extends('layouts.print')

@section('title', 'Cetak Label Barang Bukti')

@section('content')
    <div class="no-print p-3 d-flex justify-content-end">
        <form method="POST" action="{{ route('admin.surat.tandai-cetak') }}" onsubmit="return confirm('Tandai {{ $suratList->count() }} label ini sebagai sudah dicetak? Setelah ditandai, label akan hilang dari antrian dan masuk ke Riwayat Surat.');">
            @csrf
            @foreach ($suratList as $s)
                <input type="hidden" name="ids[]" value="{{ $s->id_surat }}">
            @endforeach
            <button type="submit" class="btn btn-success btn-sm">
                <x-heroicon-o-check-circle class="me-1" /> Tandai Sudah Dicetak
            </button>
        </form>
    </div>

    @foreach ($suratList->chunk(4) as $chunk)
        <div class="label-print-page" style="{{ !$loop->last ? 'page-break-after: always;' : '' }}">
            @foreach ($chunk as $s)
                <div class="label-card">
                    <div class="label-header">
                        <div class="kop-text">
                            <h6>KEPOLISIAN REPUBLIK INDONESIA</h6>
                            <h6>DAERAH SUMATERA UTARA</h6>
                            <h6 class="underline">BIDANG LABORATORIUM FORENSIK</h6>
                        </div>
                        <div class="label-qr">
                            <img src="{{ \App\Support\QrGenerator::dataUri(route('qr.show', $s->qrToken()), 320) }}" alt="QR {{ $s->no_surat }}">
                        </div>
                    </div>

                    <div class="label-title">LABEL BARANG BUKTI</div>

                    <div class="label-field">
                        <div class="label-key">No. LAB</div>
                        <div>: {{ $s->no_surat }}</div>
                    </div>
                    <div class="label-field">
                        <div class="label-key">Barang Bukti</div>
                        <div>: {{ $s->barangBukti?->nama }}</div>
                    </div>
                    <div class="label-field">
                        <div class="label-key">Tersangka</div>
                        <div>: <strong>{{ $s->tersangka }}</strong></div>
                    </div>
                    <div class="label-field">
                        <div class="label-key">Berasal Dari</div>
                        <div>: {{ $s->lokasi_penangkapan }}</div>
                    </div>

                    <div class="label-sign">
                        <div>Medan, {{ $s->tglSuratFormatted() }}</div>
                        @if($s->penanggungJawab?->ttdUrl())
                            <img src="{{ $s->penanggungJawab->ttdUrl() }}" class="ttd" alt="TTD">
                        @else
                            <div style="height:50px;"></div>
                        @endif
                        <div><strong>{{ $s->penanggungJawab?->nama }}</strong></div>
                        <div>{{ $s->penanggungJawab?->jabatan }}</div>
                        <div>{{ $s->penanggungJawab?->nrp }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
