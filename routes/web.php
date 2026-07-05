<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\AuthController;

Route::get('/', function () { 
    return view('welcome'); 
});

// ==========================================
// RUTE LOGIN & REGISTER
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']); 

// Rute Pendaftaran Warga (Nama disesuaikan agar tombol 'register' di welcome.blade.php tidak error)
Route::get('/register', [PelangganController::class, 'registerWarga'])->name('register');
Route::post('/register', [PelangganController::class, 'storeRegisterWarga'])->name('register.warga.store');


// ==========================================
// RUTE ADMIN (Wajib Login)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [TagihanController::class, 'dashboard'])->name('admin.dashboard');
    
    // Manajemen Pelanggan
    Route::get('/admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan.index');
    Route::get('/admin/pelanggan/create', [PelangganController::class, 'create'])->name('admin.pelanggan.create');
    Route::post('/admin/pelanggan', [PelangganController::class, 'store'])->name('admin.pelanggan.store');
    Route::delete('/admin/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');
    
    // Persetujuan Warga
    Route::get('/admin/pelanggan/persetujuan', [PelangganController::class, 'persetujuan'])->name('admin.pelanggan.persetujuan');
    Route::post('/admin/pelanggan/{id}/setujui', [PelangganController::class, 'setujui'])->name('admin.pelanggan.setujui');
    
    // Manajemen Tagihan
    Route::get('/admin/tagihan', [TagihanController::class, 'index'])->name('admin.tagihan.index');
    Route::get('/admin/tagihan/create', [TagihanController::class, 'create'])->name('admin.tagihan.create');
    Route::post('/admin/tagihan', [TagihanController::class, 'store'])->name('admin.tagihan.store');
    Route::delete('/admin/tagihan/{id}', [TagihanController::class, 'destroy'])->name('admin.tagihan.destroy');
    
    // Fitur Tambahan
    Route::get('/admin/tagihan/{id}/cetak', [TagihanController::class, 'cetak'])->name('admin.tagihan.cetak');
    Route::post('/admin/tagihan/{id}/cash', [TagihanController::class, 'konfirmasiLunas'])->name('admin.tagihan.cash');
    Route::get('/admin/tagihan/{id}/cash', [TagihanController::class, 'konfirmasiLunas']); 
    Route::get('/admin/tagihan/laporan', [TagihanController::class, 'laporan'])->name('admin.tagihan.laporan');
});


// ==========================================
// RUTE WARGA
// ==========================================
Route::get('/cek-tagihan', [PelangganController::class, 'cekTagihan'])->name('warga.cek_tagihan');
Route::get('/cari-tagihan', [PelangganController::class, 'cariTagihan'])->name('warga.cari_tagihan');