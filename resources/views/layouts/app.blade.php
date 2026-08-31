<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - SISPAMBBLABFOR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="app-shell d-flex">

    <div class="offcanvas-lg offcanvas-start app-sidebar" tabindex="-1" id="sidebar">
        <div class="d-flex flex-column h-100 p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 sispam-brand">
                    <img src="{{ asset('images/polda.png') }}" alt="Polda Sumut" class="brand-logo">
                    <span class="fw-bold small lh-sm">SISPAMBBLABFOR<br><span class="fw-normal text-muted">Polda Sumut</span></span>
                </a>
                <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebar"></button>
            </div>

            <ul class="nav nav-pills flex-column mb-auto gap-1 mt-3">
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <x-heroicon-o-squares-2x2 /> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.barang-bukti.index') }}" class="nav-link {{ request()->routeIs('admin.barang-bukti.*') ? 'active' : '' }}">
                                <x-heroicon-o-beaker /> Barang Bukti
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.penanggung-jawab.index') }}" class="nav-link {{ request()->routeIs('admin.penanggung-jawab.*') ? 'active' : '' }}">
                                <x-heroicon-o-identification /> Penanggung Jawab
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.surat.index') }}" class="nav-link {{ request()->routeIs('admin.surat.index') ? 'active' : '' }}">
                                <x-heroicon-o-envelope /> Label Surat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.surat.riwayat') }}" class="nav-link {{ request()->routeIs('admin.surat.riwayat') ? 'active' : '' }}">
                                <x-heroicon-o-clock /> Riwayat Surat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.manage-storage.index') }}" class="nav-link {{ request()->routeIs('admin.manage-storage.*') ? 'active' : '' }}">
                                <x-heroicon-o-server-stack /> Manage Storage
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <x-heroicon-o-squares-2x2 /> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('operator.surat.index') }}" class="nav-link {{ request()->routeIs('operator.surat.*') ? 'active' : '' }}">
                                <x-heroicon-o-envelope /> Label Surat Saya
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            @auth
                <div class="border-top pt-3 mt-3">
                    <div class="small text-muted mb-2">
                        Masuk sebagai<br>
                        <strong class="text-body">{{ auth()->user()->name }}</strong>
                        <span class="status-pill text-uppercase" style="background: var(--sispam-primary-soft); color: var(--sispam-primary-dark);">{{ auth()->user()->role }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm w-100">
                            <x-heroicon-o-arrow-right-start-on-rectangle class="me-1" /> Keluar
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    <main class="app-main flex-grow-1">
        <div class="app-topbar px-3 px-lg-4 py-3 d-flex justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary btn-icon d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                    <x-heroicon-o-bars-3 class="fs-5" />
                </button>
                <h6 class="mb-0">@yield('title', 'Dashboard')</h6>
            </div>
        </div>

        <div class="p-3 p-lg-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0" role="alert" style="background-color: var(--sispam-success-soft); color: var(--sispam-success);">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0" role="alert" style="background-color: var(--sispam-danger-soft); color: var(--sispam-danger);">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0" role="alert" style="background-color: var(--sispam-danger-soft); color: var(--sispam-danger);">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<div class="modal fade" id="photoLightbox" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal"></button>
            <img src="" class="w-100" style="border-radius: 12px;" id="photoLightboxImg">
        </div>
    </div>
</div>

@stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('photoLightbox');
        if (!modalEl) return;
        const modal = new bootstrap.Modal(modalEl);
        const modalImg = document.getElementById('photoLightboxImg');

        document.querySelectorAll('.foto-bb-thumb').forEach(function (img) {
            img.style.cursor = 'zoom-in';
            img.addEventListener('click', function () {
                modalImg.src = img.src;
                modal.show();
            });
        });
    });
</script>
</body>
</html>
