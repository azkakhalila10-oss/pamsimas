<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Warga - SI PAMSIMAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        .register-card {
            background-color: #1e293b;
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
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
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }
        .form-control::placeholder {
            color: #64748b !important;
        }
        .btn-success {
            background-color: #10b981;
            border: none;
            font-weight: 600;
        }
        .btn-success:hover {
            background-color: #059669;
        }
        .input-group-text {
            background-color: #334155;
            border: 1px solid #334155;
            color: #cbd5e1;
        }
        .text-light-gray {
            color: #94a3b8 !important;
        }
    </style>
</head>
<body>

    <div class="container d-flex flex-column align-items-center">
        <!-- Logo dan Judul -->
        <div class="text-center mb-4">
            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2 shadow" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-droplet fs-3"></i>
            </div>
            <h3 class="fw-bold mb-0 text-white">SI PAMSIMAS</h3>
            <small class="text-light-gray text-uppercase fw-semibold" style="letter-spacing: 1px; font-size: 0.75rem;">Registrasi Pelanggan Baru</small>
        </div>

        <!-- Card Form Register -->
        <div class="register-card border border-secondary border-opacity-25">
            
            <div class="text-center mb-4">
                <h4 class="fw-bold mb-1 text-white">Form Pendaftaran</h4>
                <p class="text-light-gray small mb-0">Lengkapi data di bawah ini untuk mengajukan akun.</p>
            </div>

            <!-- Pesan Validasi Error -->
            @if($errors->any())
                <div class="alert alert-warning border-0 small py-2 text-white" role="alert" style="background-color: #f59e0b;">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <!-- FORM REGISTER -->
            <form action="{{ url('/register') }}" method="POST">
                @csrf
                
                <!-- 1. Nama Lengkap -->
                <div class="mb-3">
                    <label class="form-label text-light-gray small fw-medium">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="name" class="form-control border-start-0 ps-0" placeholder="Contoh: Aulia Rahman" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <!-- 2. NIK -->
                <div class="mb-3">
                    <label class="form-label text-light-gray small fw-medium">Nomor Induk Kependudukan (NIK)</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="fa-solid fa-id-card"></i></span>
                        <input type="number" name="nik" class="form-control border-start-0 ps-0" placeholder="16 digit NIK KTP Anda" value="{{ old('nik') }}" required>
                    </div>
                </div>

                <!-- 3. Alamat Rumah -->
                <div class="mb-3">
                    <label class="form-label text-light-gray small fw-medium">Alamat Lengkap / Wilayah</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="text" name="alamat" class="form-control border-start-0 ps-0" placeholder="Contoh: RT 02 Korong Padang Lariang" value="{{ old('alamat') }}" required>
                    </div>
                </div>

                <!-- 4. Email -->
                <div class="mb-3">
                    <label class="form-label text-light-gray small fw-medium">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <!-- 5. Kata Sandi -->
                <div class="mb-3">
                    <label class="form-label text-light-gray small fw-medium">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Minimal 8 karakter" required>
                    </div>
                </div>

                <!-- 6. Konfirmasi Kata Sandi -->
                <div class="mb-4">
                    <label class="form-label text-light-gray small fw-medium">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password_confirmation" class="form-control border-start-0 ps-0" placeholder="Ulangi kata sandi" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2 shadow-sm mb-3">
                    <i class="fa-solid fa-user-plus me-2"></i> Ajukan Pendaftaran
                </button>

                <div class="text-center small mt-2">
                    <span class="text-light-gray">Sudah punya akun?</span> 
                    <a href="{{ url('/login') }}" class="text-primary text-decoration-none fw-semibold ms-1">Masuk Sekarang</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>