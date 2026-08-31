<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cetak') - SISPAMBBLABFOR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @page { margin: 0; }
        body { background: #fff; }
    </style>
</head>
<body>
    <div class="no-print p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
            <x-heroicon-o-arrow-left /> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            <x-heroicon-o-printer /> Cetak
        </button>
    </div>

    @yield('content')
</body>
</html>
