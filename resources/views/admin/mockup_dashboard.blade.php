@extends('layouts.admin_master')

@section('title', 'Dashboard Utama')

@section('content')
<!-- Banner Selamat Datang -->
<div class="card border-0 text-white shadow-sm mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); border-radius: 16px;">
    <div class="card-body p-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Selamat Datang di Panel PAMSIMAS, Admin</h4>
            <p class="m-0 text-white-50" style="font-size: 0.8rem; max-width: 650px;">Monitoring penggunaan kubikasi air bersih, validasi pembayaran iuran warga, dan manajemen pelanggan dalam satu dasbor terpusat.</p>
        </div>
        <div class="fs-1 d-none d-md-block opacity-75">💧</div>
    </div>
</div>

<!-- TIGA KOTAK KARTU STATISTIK (GLASSMORPHISM EFFECT) -->
<div class="row g-4 mb-5">
    <!-- Kartu 1: Total Pelanggan -->
    <div class="col-md-4">
        <div class="card p-4 shadow-sm" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(8px); border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 12px; transition: transform 0.2s;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted fw-semibold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.7rem;">Total Warga Terdaftar</small>
                    <h3 class="m-0 fw-bold text-dark">142 <span class="fs-6 text-muted fw-normal">Rumah</span></h3>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; font-size: 1.3rem;">👥</div>
            </div>
        </div>
    </div>

    <!-- Kartu 2: Tagihan Bulan Ini -->
    <div class="col-md-4">
        <div class="card p-4 shadow-sm" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(8px); border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 12px; transition: transform 0.2s;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted fw-semibold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.7rem;">Total Tagihan Air (Juni)</small>
                    <h3 class="m-0 fw-bold text-dark">Rp 4.250.000</h3>
                </div>
                <div class="bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; font-size: 1.3rem;">💰</div>
            </div>
        </div>
    </div>

    <!-- Kartu 3: Menunggu Verifikasi -->
    <div class="col-md-4">
        <div class="card p-4 shadow-sm" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(8px); border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 12px; transition: transform 0.2s;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted fw-semibold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.7rem;">Menunggu Verifikasi Struk</small>
                    <h3 class="m-0 fw-bold text-warning">8 <span class="fs-6 text-warning opacity-75 fw-normal">Antrean</span></h3>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; font-size: 1.3rem;">⏳</div>
            </div>
        </div>
    </div>
</div>

<!-- TABEL REKAPAN TERBARU -->
<div class="card border shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(8px); border-radius: 12px; overflow: hidden;">
    <div class="card-header bg-dark py-3 border-0 text-center text-white fw-bold text-uppercase tracking-wide" style="font-size: 0.85rem; background-color: #0f172a !important;">
        AKTIVITAS PENDAFTARAN WARGA TERBARU
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-light text-uppercase tracking-wider" style="font-size: 0.75rem;">
                <tr>
                    <th class="py-3 px-4 text-start" style="width: 25%;">ID Pelanggan</th>
                    <th class="py-3 px-4 text-start">Nama Kepala Keluarga</th>
                    <th class="py-3 px-4">Wilayah Rumah / RT</th>
                    <th class="py-3 px-4">Status Rekening</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.85rem; font-weight: 500;" class="text-secondary">
            </tbody>
        </table>
    </div>
</div>

<div class="text-center text-muted mt-5 mb-3" style="font-size: 0.75rem;">
    © 2026 SI PAMSIMAS - Layanan Air Bersih Masyarakat Desa.
</div>
@endsection