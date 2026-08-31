<?php

use App\Http\Controllers\Admin\BarangBuktiController;
use App\Http\Controllers\Admin\LampiranController;
use App\Http\Controllers\Admin\ManageStorageController;
use App\Http\Controllers\Admin\PenanggungJawabController;
use App\Http\Controllers\Admin\SuratController as AdminSuratController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Operator\FotoBbController;
use App\Http\Controllers\Operator\SuratController as OperatorSuratController;
use App\Http\Controllers\Public\QrController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Halaman verifikasi publik dari QR code label (tanpa login).
Route::get('/qr/{token}', [QrController::class, 'show'])->name('qr.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // URL harus persis sama dengan produksi: /foto-bb/cetak/{id_surat}
    Route::middleware('role:admin')->get('/foto-bb/cetak/{surat}', [LampiranController::class, 'show'])
        ->name('lampiran.show');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('barang-bukti', BarangBuktiController::class)->except(['show']);
        Route::resource('penanggung-jawab', PenanggungJawabController::class)->except(['show']);

        Route::get('surat/cetak', [AdminSuratController::class, 'cetak'])->name('surat.cetak');
        Route::get('surat/riwayat', [AdminSuratController::class, 'riwayat'])->name('surat.riwayat');
        Route::post('surat/tandai-cetak', [AdminSuratController::class, 'tandaiCetak'])->name('surat.tandai-cetak');
        Route::post('surat/hapus-massal', [AdminSuratController::class, 'bulkDestroy'])->name('surat.bulk-destroy');
        Route::get('surat', [AdminSuratController::class, 'index'])->name('surat.index');
        Route::get('surat/{surat}/edit', [AdminSuratController::class, 'edit'])->name('surat.edit');
        Route::put('surat/{surat}', [AdminSuratController::class, 'update'])->name('surat.update');
        Route::delete('surat/{surat}', [AdminSuratController::class, 'destroy'])->name('surat.destroy');

        Route::get('manage-storage', [ManageStorageController::class, 'index'])->name('manage-storage.index');
        Route::post('manage-storage/preview', [ManageStorageController::class, 'preview'])->name('manage-storage.preview');
        Route::post('manage-storage', [ManageStorageController::class, 'destroy'])->name('manage-storage.destroy');
    });

    Route::prefix('operator')->name('operator.')->middleware('role:operator')->group(function () {
        Route::get('surat', [OperatorSuratController::class, 'index'])->name('surat.index');
        Route::get('surat/create', [OperatorSuratController::class, 'create'])->name('surat.create');
        Route::post('surat', [OperatorSuratController::class, 'store'])->name('surat.store');
        Route::get('surat/{surat}', [OperatorSuratController::class, 'show'])->name('surat.show');
        Route::get('surat/{surat}/edit', [OperatorSuratController::class, 'edit'])->name('surat.edit');
        Route::put('surat/{surat}', [OperatorSuratController::class, 'update'])->name('surat.update');
        Route::post('surat/{surat}/kirim', [OperatorSuratController::class, 'kirim'])->name('surat.kirim');

        Route::get('surat/{surat}/upload-bb', [FotoBbController::class, 'index'])->name('foto-bb.index');
        Route::post('surat/{surat}/upload-bb', [FotoBbController::class, 'store'])->name('foto-bb.store');
        Route::delete('foto-bb/{fotoBb}', [FotoBbController::class, 'destroy'])->name('foto-bb.destroy');
    });
});
