<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - SISPAMBBLABFOR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex align-items-center justify-content-center p-3" style="min-height: 100vh; background: var(--sispam-bg);">
    <img src="{{ asset('images/polda.png') }}" alt="" class="login-watermark">
    <div class="soft-card login-form-card shadow-sm" style="width: 100%; max-width: 380px;">
        <div class="p-4">
            <div class="text-center mb-4">
                <img src="{{ asset('images/polda.png') }}" alt="Polda Sumut" class="login-logo mb-2">
                <h5 class="mt-1 mb-0">SISPAMBBLABFOR</h5>
                <small class="text-muted">Sistem Pengamanan Barang Bukti<br>Laboratorium Forensik Polda Sumut</small>
            </div>

            @if ($errors->any())
                <div class="alert border-0 py-2 small mb-3" style="background-color: var(--sispam-danger-soft); color: var(--sispam-danger);">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" required autofocus autocapitalize="off" autocorrect="off">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Kata Sandi</label>
                    <div class="position-relative">
                        <input type="password" name="password" id="password" class="form-control pe-5" required>
                        <button type="button" id="togglePassword" class="btn btn-sm position-absolute top-0 end-0 h-100 d-flex align-items-center text-muted px-3" style="background: transparent; border: none;" tabindex="-1">
                            <x-heroicon-o-eye id="eyeIcon" />
                            <x-heroicon-o-eye-slash id="eyeSlashIcon" class="d-none" />
                        </button>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';
            eyeIcon.classList.toggle('d-none', isHidden);
            eyeSlashIcon.classList.toggle('d-none', !isHidden);
        });
    </script>
</body>
</html>
