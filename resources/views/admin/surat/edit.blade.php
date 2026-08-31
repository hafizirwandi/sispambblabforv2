@extends('layouts.app')

@section('title', 'Lengkapi Data Surat - '.$surat->no_surat)

@section('content')
    <div class="row g-3">
        <div class="col-md-7">
            <div class="soft-card">
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.surat.update', $surat) }}">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">No. Label / No. Surat</label>
                            <input type="text" name="no_surat" class="form-control" value="{{ old('no_surat', $surat->no_surat) }}" required autofocus>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Barang Bukti</label>
                                <select name="id_bb" class="form-select" required>
                                    <option value="" disabled @selected(old('id_bb', $surat->id_bb) == 0)>-- Pilih Barang Bukti --</option>
                                    @foreach ($barangBukti as $bb)
                                        <option value="{{ $bb->id_bb }}" @selected(old('id_bb', $surat->id_bb) == $bb->id_bb)>{{ $bb->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Penanggung Jawab / Pemeriksa</label>
                                <select name="id_pj" class="form-select" required>
                                    <option value="" disabled @selected(old('id_pj', $surat->id_pj) == 0)>-- Pilih Penanggung Jawab --</option>
                                    @foreach ($penanggungJawab as $pj)
                                        <option value="{{ $pj->id_pj }}" @selected(old('id_pj', $surat->id_pj) == $pj->id_pj)>{{ $pj->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tersangka</label>
                            <input type="text" name="tersangka" class="form-control" value="{{ old('tersangka', $surat->tersangka) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Berasal Dari / Lokasi Penangkapan</label>
                            <input type="text" name="lokasi_penangkapan" class="form-control" value="{{ old('lokasi_penangkapan', $surat->lokasi_penangkapan) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Surat</label>
                                <input type="date" name="tgl_surat" class="form-control" value="{{ old('tgl_surat', $surat->tgl_surat->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waktu Penangkapan</label>
                                <input type="time" name="waktu_penangkapan" class="form-control" value="{{ old('waktu_penangkapan', $surat->waktu_penangkapan) }}" required>
                            </div>
                        </div>

                        <button class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.surat.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="soft-card">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Lampiran Foto Barang Bukti</h6>
                        <a href="{{ route('lampiran.show', $surat) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <x-heroicon-o-printer /> Cetak Lampiran
                        </a>
                    </div>
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
@endsection
