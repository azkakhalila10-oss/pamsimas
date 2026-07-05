<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI PAMSIMAS - Portal Utama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <!-- Header Judul -->
        <div class="text-center mb-5">
            <i class="fa-solid fa-droplet fa-4x text-primary mb-3"></i>
            <h1 class="fw-bold text-dark">Sistem Informasi PAMSIMAS</h1>
            <p class="text-muted">Pilih portal akses Anda di bawah ini</p>
        </div>

        <div class="row justify-content-center gap-4">
            <!-- Kotak Portal Warga -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="card-body d-flex flex-column">
                        <i class="fa-solid fa-users fa-3x text-success mb-3"></i>
                        <h4 class="fw-bold">Portal Warga</h4>
                        <p class="text-muted mb-4">Cek tagihan air, unggah bukti pembayaran, atau daftar sebagai pelanggan baru tanpa perlu login.</p>
                        
                        <div class="mt-auto">
                            <!-- Tombol Mengarah ke Rute Warga -->
                            <a href="{{ route('warga.cek_tagihan') }}" class="btn btn-success w-100 mb-2 fw-bold">Cek Tagihan Air</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-success w-100 fw-bold">Pendaftaran Warga Baru</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kotak Portal Admin -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="card-body d-flex flex-column">
                        <i class="fa-solid fa-user-shield fa-3x text-primary mb-3"></i>
                        <h4 class="fw-bold">Portal Admin</h4>
                        <p class="text-muted mb-4">Masuk ke panel kontrol untuk mengelola data pelanggan, validasi pendaftaran, dan kelola tagihan air.</p>
                        
                        <div class="mt-auto">
                            <!-- Tombol Mengarah ke Rute Login Admin -->
                            <a href="{{ route('login') }}" class="btn btn-primary w-100 fw-bold">Login Admin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>