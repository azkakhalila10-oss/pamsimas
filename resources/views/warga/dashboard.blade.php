<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warga - SI PAMSIMAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fa-solid fa-droplet me-2"></i>SI PAMSIMAS
            </a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Halo, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fa-solid fa-power-off me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px;">
                            <i class="fa-solid fa-check fs-1"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Selamat Datang di Portal Pelanggan!</h3>
                        <p class="text-muted">Akun Anda atas nama <strong>{{ Auth::user()->name }}</strong> (NIK: {{ Auth::user()->nik }}) telah berhasil diverifikasi oleh sistem PAMSIMAS.</p>
                        
                        <hr class="my-4">
                        
                        <p class="text-secondary small">Fitur pengecekan tagihan dan riwayat meteran air akan segera hadir di halaman ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>