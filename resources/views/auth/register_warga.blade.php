<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Warga PAMSIMAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3 shadow" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-droplet fa-2x"></i>
                </div>
                <h3 class="fw-bold">Pendaftaran PAMSIMAS</h3>
                <p class="text-muted">Korong Padang Lariang Barat</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success border-0 border-start border-success border-4 rounded-3">
                            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger border-0 border-start border-danger border-4 rounded-3">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('register.warga.store') }}" method="POST">
                        @csrf
                        
                        <!-- Kolom NIK Baru -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Nomor Induk Kependudukan (NIK)</label>
                            <input type="number" name="NIK" class="form-control form-control-lg bg-light border-0" required placeholder="Masukkan 16 digit NIK Anda">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control form-control-lg bg-light border-0" required placeholder="Sesuai KTP">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Nomor HP / WhatsApp</label>
                            <input type="number" name="no_hp" class="form-control form-control-lg bg-light border-0" required placeholder="Contoh: 081234567890">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control bg-light border-0" rows="3" required placeholder="Detail alamat di Korong Padang Lariang Barat"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 shadow-sm mt-2">
                            Kirim Formulir Pendaftaran
                        </button>
                        
                        <div class="text-center mt-4">
                            <a href="/" class="text-decoration-none text-muted"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Halaman Utama</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>