@extends('layouts.print')

@section('title', 'Cetak Label Barang Bukti')

@section('content')
    @foreach ($suratList->chunk(4) as $chunk)
        <div class="label-print-page" style="{{ !$loop->last ? 'page-break-after: always;' : '' }}">
            @foreach ($chunk as $s)
                <div class="label-card">
                    <div class="label-header">
                        <div>
                            <h6>KEPOLISIAN REPUBLIK INDONESIA</h6>
                            <h6>DAERAH SUMATERA UTARA</h6>
                            <h6 class="underline">BIDANG LABORATORIUM FORENSIK</h6>
                        </div>
                        <div class="label-qr">
                            <img src="{{ \App\Support\QrGenerator::dataUri(route('qr.show', $s->qrToken())) }}" alt="QR {{ $s->no_surat }}">
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
