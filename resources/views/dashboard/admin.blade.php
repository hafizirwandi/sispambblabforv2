@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row g-3">
        <div class="col-6 col-lg-3">
            <div class="stat-tile">
                <div class="stat-label">Menunggu Diproses</div>
                <div class="stat-value">{{ $stats['menunggu'] }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-tile">
                <div class="stat-label">Selesai</div>
                <div class="stat-value">{{ $stats['selesai'] }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-tile">
                <div class="stat-label">Master Barang Bukti</div>
                <div class="stat-value">{{ $stats['barang_bukti'] }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-tile">
                <div class="stat-label">Penanggung Jawab</div>
                <div class="stat-value">{{ $stats['penanggung_jawab'] }}</div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.surat.index') }}" class="btn btn-primary">
            <x-heroicon-o-envelope class="me-1" /> Kelola Label Surat
        </a>
    </div>
@endsection
