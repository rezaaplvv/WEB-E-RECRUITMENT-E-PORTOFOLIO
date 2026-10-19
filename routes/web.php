<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/lowongan', [PublicController::class, 'lowongan'])->name('lowongan.index');
Route::get('/lowongan/{slug}', [PublicController::class, 'detailLowongan'])->name('lowongan.detail');
Route::get('/talenta', [PublicController::class, 'talenta'])->name('talenta.index');
Route::get('/talenta/{id}', [PublicController::class, 'detailTalenta'])->name('talenta.detail');
Route::get('/talenta/{id}/cetak-cv', [PelamarController::class, 'cetakCvDigital'])->name('talenta.cv.digital');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register/pelamar', [AuthController::class, 'registerPelamar'])->name('register.pelamar');
Route::post('/register/perusahaan', [AuthController::class, 'registerPerusahaan'])->name('register.perusahaan');

/*
|--------------------------------------------------------------------------
| Panel Pelamar / Mahasiswa (Middleware: role:pelamar)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pelamar'])->prefix('pelamar')->name('pelamar.')->group(function () {
    Route::get('/dashboard', [PelamarController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [PelamarController::class, 'profil'])->name('profil');
    Route::post('/profil', [PelamarController::class, 'updateProfil'])->name('profil.update');

    // Portfolio CRUD
    Route::get('/portofolio', [PelamarController::class, 'portofolio'])->name('portofolio.index');
    Route::post('/portofolio', [PelamarController::class, 'storePortofolio'])->name('portofolio.store');
    Route::put('/portofolio/{id}', [PelamarController::class, 'updatePortofolio'])->name('portofolio.update');
    Route::delete('/portofolio/{id}', [PelamarController::class, 'destroyPortofolio'])->name('portofolio.destroy');

    // Applications & Tracking
    Route::get('/lamaran', [PelamarController::class, 'lamaran'])->name('lamaran.index');
    Route::post('/lowongan/{lowonganId}/apply', [PelamarController::class, 'apply'])->name('lamaran.apply');
    Route::get('/lamaran/{kode}', [PelamarController::class, 'showLamaran'])->name('lamaran.show');
    Route::get('/lamaran/{kode}/cetak-interview', [PelamarController::class, 'cetakBuktiInterview'])->name('lamaran.cetak-interview');

    // Saved Vacancies (Bookmarks)
    Route::get('/bookmarks', [PelamarController::class, 'bookmarks'])->name('bookmarks.index');
    Route::post('/bookmarks/{lowonganId}/toggle', [PelamarController::class, 'toggleBookmark'])->name('bookmarks.toggle');

    // Digital Academic Resume PDF
    Route::get('/cetak-cv-digital', [PelamarController::class, 'cetakCvDigital'])->name('cv.digital');
});

/*
|--------------------------------------------------------------------------
| In-App Notifications (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/{id}/baca', [NotificationController::class, 'markAsRead'])->name('notifikasi.baca');
    Route::post('/notifikasi/baca-semua', [NotificationController::class, 'markAllAsRead'])->name('notifikasi.baca-semua');
});

/*
|--------------------------------------------------------------------------
| Panel Perusahaan / HRD Mitra (Middleware: role:perusahaan)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:perusahaan'])->prefix('perusahaan')->name('perusahaan.')->group(function () {
    Route::get('/dashboard', [PerusahaanController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [PerusahaanController::class, 'profil'])->name('profil');
    Route::post('/profil', [PerusahaanController::class, 'updateProfil'])->name('profil.update');

    // Vacancies Management
    Route::get('/lowongan', [PerusahaanController::class, 'lowonganIndex'])->name('lowongan.index');
    Route::get('/lowongan/buat', [PerusahaanController::class, 'lowonganCreate'])->name('lowongan.create');
    Route::post('/lowongan', [PerusahaanController::class, 'lowonganStore'])->name('lowongan.store');
    Route::get('/lowongan/{id}/edit', [PerusahaanController::class, 'lowonganEdit'])->name('lowongan.edit');
    Route::put('/lowongan/{id}', [PerusahaanController::class, 'lowonganUpdate'])->name('lowongan.update');
    Route::post('/lowongan/{id}/toggle-status', [PerusahaanController::class, 'lowonganToggleStatus'])->name('lowongan.toggle');
    Route::delete('/lowongan/{id}', [PerusahaanController::class, 'lowonganDestroy'])->name('lowongan.destroy');

    // Applicant Selection & E-Interview Scheduling
    Route::get('/pelamar', [PerusahaanController::class, 'pelamarIndex'])->name('pelamar.index');
    Route::get('/pelamar/{id}', [PerusahaanController::class, 'pelamarDetail'])->name('pelamar.detail');
    Route::post('/pelamar/{id}/status', [PerusahaanController::class, 'updateStatusLamaran'])->name('pelamar.status');

    // Recruitment Report PDF
    Route::get('/laporan', [PerusahaanController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/cetak-pdf', [PerusahaanController::class, 'cetakLaporanPdf'])->name('laporan.pdf');
});

/*
|--------------------------------------------------------------------------
| Panel Admin Prodi D3 TI USU (Middleware: role:admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/perusahaan', [AdminController::class, 'perusahaanIndex'])->name('perusahaan.index');
    Route::post('/perusahaan/{id}/verifikasi', [AdminController::class, 'verifikasiPerusahaan'])->name('perusahaan.verifikasi');
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle');
    Route::get('/lowongan', [AdminController::class, 'lowonganIndex'])->name('lowongan.index');

    // Executive Academic Report PDF
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/cetak-pdf', [AdminController::class, 'cetakLaporanPdf'])->name('laporan.pdf');
});
