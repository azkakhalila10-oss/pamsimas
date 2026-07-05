<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - SI PAMSIMAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* Animasi */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .efek-naik { animation: fadeInUp 0.5s ease-out forwards; }

        body { background-color: #f8fafc; font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        
        /* Sidebar Styling */
        .sidebar { width: 260px; height: 100vh; position: fixed; top: 0; left: 0; background-color: #0f172a; color: #94a3b8; z-index: 1000; }
        .sidebar-brand { padding: 1.5rem; color: #ffffff; font-weight: 700; border-bottom: 1px solid #1e293b; }
        .sidebar-menu { padding: 1rem 0; list-style: none; margin: 0; }
        .sidebar-item a { display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #94a3b8; text-decoration: none; font-weight: 500; transition: all 0.2s; border-left: 4px solid transparent; }
        .sidebar-item a:hover { background-color: #1e293b; color: #f8fafc; }
        .sidebar-item.active a { background-color: #1e293b; color: #3b82f6; border-left-color: #3b82f6; font-weight: 600; }
        .sidebar-item i { width: 24px; font-size: 1.1rem; margin-right: 10px; }
        
        .sidebar-profile { position: absolute; bottom: 0; width: 100%; padding: 1rem; background-color: #1e293b; border-top: 1px solid #0f172a; }
        
        /* Main Content - Dibuat flex agar tidak terpotong */
        .wrapper { display: flex; }
        .main-content { flex: 1; margin-left: 260px; padding: 2rem; min-height: 100vh; }
        
        .top-navbar { background-color: #ffffff; padding: 0.75rem 1.5rem; border-radius: 10px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>

<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand d-flex align-items-center gap-2">
            <i class="fa-solid fa-droplet text-primary fs-3"></i>
            <div>
                <div class="lh-1 text-white small fw-bold">SI PAMSIMAS</div>
                <small style="font-size: 0.65rem; color: #94a3b8; font-weight: 600; letter-spacing: 0.5px;">PADANG LARIANG BARAT</small>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-pie"></i> Halaman Utama</a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.pelanggan.index') ? 'active' : '' }}">
                <a href="{{ route('admin.pelanggan.index') }}"><i class="fa-solid fa-users"></i> Data Warga</a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.pelanggan.persetujuan') ? 'active' : '' }}">
                <a href="{{ route('admin.pelanggan.persetujuan') }}" class="text-warning"><i class="fa-solid fa-bell"></i> Validasi Pendaftaran</a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.tagihan.create') ? 'active' : '' }}">
                <a href="{{ route('admin.tagihan.create') }}"><i class="fa-solid fa-faucet-drip"></i> Catat Meteran Air</a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.tagihan.index') ? 'active' : '' }}">
                <a href="{{ route('admin.tagihan.index') }}"><i class="fa-solid fa-credit-card"></i> Validasi Pembayaran</a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.tagihan.laporan') ? 'active' : '' }}">
                <a href="{{ route('admin.tagihan.laporan') }}"><i class="fa-solid fa-file-invoice-dollar"></i> Cetak Laporan</a>
            </li>
        </ul>

        <div class="sidebar-profile d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px; font-size: 0.85rem;">AD</div>
                <div><div class="text-white small fw-bold m-0 p-0 lh-1">Admin</div><small class="text-muted" style="font-size: 0.7rem;">Koordinator</small></div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-link text-danger p-0 border-0" onclick="return confirm('Yakin logout?')">
                    <i class="fa-solid fa-right-from-bracket fs-5"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-navbar d-flex justify-content-between align-items-center mb-4">
            <div class="fw-semibold text-secondary small">Halaman &rsaquo; <span class="text-dark">@yield('title', 'Admin Panel')</span></div>
            <div class="badge bg-success-subtle text-success border border-success px-2 py-2 fw-bold text-uppercase" style="font-size: 0.7rem;">● Server Active</div>
        </div>

        <div class="content-body efek-naik">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>