<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SI PAMSIMAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #0f172a; 
            color: #f8fafc;
        }
        .card-login {
            background-color: #1e293b;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #f8fafc;
        }
        .form-control:focus {
            background-color: #0f172a;
            border-color: #3b82f6;
            color: #f8fafc;
            box-shadow: none;
        }
        .input-group-text {
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #94a3b8;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <!-- Logo & Judul -->
                <div class="text-center mb-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-droplet text-white fs-3"></i>
                    </div>
                    <!-- Ditambahkan text-white agar judul putih bersih -->
                    <h2 class="fw-bold mb-0 text-white">SI PAMSIMAS</h2>
                    <p class="text-secondary small text-uppercase" style="letter-spacing: 1px;">Padang Lariang Barat</p>
                </div>

                <!-- Kotak Login -->
                <div class="card card-login p-4">
                    <div class="text-center mb-4">
                        <!-- Diubah menjadi h3 dan ditambah text-white agar besar dan jelas! -->
                        <h3 class="fw-bold text-white mb-2">Login Admin</h3>
                        <p class="text-light opacity-75 small">Silakan masuk untuk mengelola sistem.</p>
                    </div>

                    <!-- Pesan Error -->
                    @if($errors->any())
                        <div class="alert alert-danger small py-2 text-center fw-bold">
                            Email atau sandi salah!
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label small text-light">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email..." required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small text-light">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="********" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3 fs-5">
                            <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk
                        </button>
                    </form>

                    <!-- Tautan Kembali yang Baru -->
                    <div class="text-center mt-2">
                        <a href="{{ url('/') }}" class="text-decoration-none small text-info">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Halaman Utama
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>