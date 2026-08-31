@extends('layouts.app')

@section('title', 'Dashboard Operator')

@section('content')
    <div class="row g-3">
        <div class="col-6 col-lg-4">
            <div class="stat-tile">
                <div class="stat-label">Draft (belum dikirim)</div>
                <div class="stat-value">{{ $stats['draft'] }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="stat-tile">
                <div class="stat-label">Sudah Dikirim ke Admin</div>
                <div class="stat-value">{{ $stats['terkirim'] }}</div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex flex-wrap gap-2">
        <a href="{{ route('operator.surat.create') }}" class="btn btn-primary">
            <x-heroicon-o-plus class="me-1" /> Input Label Surat Baru
        </a>
        <a href="{{ route('operator.surat.index') }}" class="btn btn-outline-secondary">
            <x-heroicon-o-list-bullet class="me-1" /> Lihat Label Surat Saya
        </a>
    </div>
@endsection
