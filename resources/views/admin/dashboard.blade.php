@extends('layouts.admin_master')

@section('title', 'Dashboard Admin PAMSIMAS')

@section('content')
<style>
    /* Efek Keren: Kartu melayang saat kursor diarahkan */
    .hover-card { transition: all 0.3s ease; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important; }
</style>

<div class="container-fluid px-3 py-4">
    
    <!-- Welcome Card dengan Efek Gradasi -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="card-body py-4 px-5">
            <h3 class="fw-bold mb-1">Selamat Datang, Admin!</h3>
            <p class="mb-0 opacity-75">Sistem PAMSIMAS Korong Padang Lariang Barat siap dikelola.</p>
        </div>
    </div>

    <!-- Tiga Kartu Aksi Utama -->
    <div class="row mb-5">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card bg-primary text-white border-0 shadow hover-card rounded-4 h-100" style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
                <div class="card-body p-4">
                    <div class="text-uppercase fw-bold small mb-2 opacity-75">Total Pelanggan</div>
                    <div class="display-6 fw-bold mb-3">{{ $totalPelanggan ?? 0 }}</div>
                    <a class="text-white text-decoration-none fw-semibold" href="{{ route('admin.pelanggan.index') }}">Lihat Detail <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card bg-success text-white border-0 shadow hover-card rounded-4 h-100" style="background: linear-gradient(45deg, #198754, #20c997);">
                <div class="card-body p-4">
                    <div class="text-uppercase fw-bold small mb-2 opacity-75">Persetujuan Baru</div>
                    <div class="display-6 fw-bold mb-3">Cek</div>
                    <a class="text-white text-decoration-none fw-semibold" href="{{ route('admin.pelanggan.persetujuan') }}">Validasi Warga <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card bg-warning text-dark border-0 shadow hover-card rounded-4 h-100" style="background: linear-gradient(45deg, #ffc107, #ffdb58);">
                <div class="card-body p-4">
                    <div class="text-uppercase fw-bold small mb-2 opacity-75">Kelola Tagihan</div>
                    <div class="display-6 fw-bold mb-3">Buka</div>
                    <a class="text-dark text-decoration-none fw-semibold" href="{{ route('admin.tagihan.index') }}">Buka Menu Tagihan <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Sistem dengan Icon Elegan -->
    <h5 class="fw-bold text-dark mb-4 ms-1">Ringkasan Sistem Bulan Ini</h5>
    
    <div class="row">
        <!-- Bagan Pendapatan -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 d-flex flex-row align-items-center hover-card">
                <div class="rounded-circle p-3 me-4 d-flex align-items-center justify-content-center" style="background-color: #e0f7fa; width: 60px; height: 60px;">
                    <i class="fa-solid fa-wallet text-info fa-lg"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-bold">Total Tagihan Bulan Ini</div>
                    <h4 class="text-info fw-bold mb-0">Rp {{ number_format($totalTagihanBulanIni ?? 0, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

        <!-- Bagan Verifikasi -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 d-flex flex-row align-items-center hover-card">
                <div class="rounded-circle p-3 me-4 d-flex align-items-center justify-content-center" style="background-color: #ffebee; width: 60px; height: 60px;">
                    <i class="fa-solid fa-bell text-danger fa-lg"></i>
                </div>
                <div>
                    <div class="text-muted small text-uppercase fw-bold">Menunggu Verifikasi</div>
                    <h4 class="text-danger fw-bold mb-0">{{ $menungguVerifikasi ?? 0 }} <small class="text-muted">Antrean</small></h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection