<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran PAMSIMAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-success text-white text-center py-3">
                        <i class="fa-solid fa-user-plus fa-2x mb-2"></i>
                        <h4 class="mb-0 fw-bold">Pendaftaran Pelanggan Baru</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Area Pesan Sukses / Error -->
                        @if(session('success'))
                            <div class="alert alert-success fw-bold text-center">
                                <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger fw-bold text-center">
                                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
                            </div>
                        @endif

                        <!-- Form Pendaftaran -->
                        <form action="{{ route('register.store') }}" method="POST">
                            @csrf <!-- Ini Kunci Utamanya agar data tidak ditolak Laravel -->
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda..." required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor HP / WhatsApp</label>
                                <input type="number" name="no_hp" class="form-control" placeholder="Contoh: 08123456789" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan detail alamat rumah..." required></textarea>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success fw-bold py-2">
                                    Kirim Pendaftaran
                                </button>
                                <a href="{{ url('/') }}" class="btn btn-light border fw-bold text-muted">
                                    Batal & Kembali
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>