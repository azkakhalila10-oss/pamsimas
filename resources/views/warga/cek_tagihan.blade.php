<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tombol Kembali ke Halaman Utama -->
<div class="mt-4 mb-2 text-start">
    <a href="{{ route('warga.cek_tagihan') }}" class="btn btn-primary">Cek Tagihan</a>
    <a href="{{ url('/') }}" class="btn btn-sm btn-outline-secondary fw-bold rounded-pill px-3">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Menu Utama
    </a>
</div>
    <title>Portal Cek Iuran Air PAMSIMAS</title>
    <!-- Hubungkan ke Bootstrap 5 CDN agar tampilan modern -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* --- EFEK ANIMASI TRANSISI MASUK (ZOOM IN SMOOTH) --- */
        @keyframes zoomInSmooth {
            from {
                opacity: 0;
                transform: scale(0.96); /* Mulai dari sedikit mengecil */
            }
            to {
                opacity: 1;
                transform: scale(1); /* Kembali ke ukuran asli */
            }
        }

        .efek-warga {
            animation: zoomInSmooth 0.5s ease-out forwards; /* Durasi 0.5 detik halus */
        }

        body {
            background: linear-gradient(135deg, #e0f2fe 0%, #f0fdf4 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .portal-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
        }
    </style>
</head>
<body>

<!-- Menambahkan class "efek-warga" pada container utama agar seluruh halaman masuk dengan smooth -->
<div class="container py-5 efek-warga">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <!-- Header Portal -->
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary mb-1">SI PAMSIMAS</h2>
                <p class="text-muted fw-semibold">Portal Layanan Cek Iuran Air Bersih Warga</p>
            </div>

            <!-- Notifikasi Alert Sukses / Eror -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm fw-medium mb-4" role="alert">
                    ✓ {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm fw-medium mb-4" role="alert">
                    ✗ {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Form Pencarian -->
            <div class="card border-0 shadow-sm portal-card p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3">🔍 Cari Tagihan Anda</h5>
                <form action="{{ route('warga.cari_tagihan') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="pencarian" class="form-control form-control-lg bg-light" placeholder="Masukkan Nama Lengkap Anda..." required autocomplete="off">
                        <button type="submit" class="btn btn-primary fw-bold px-4">Cek Sekarang</button>
                    </div>
                    <div class="form-text text-secondary mt-2" style="font-size: 0.8rem;">
                        *Masukkan ejaan nama sesuai dengan data yang didaftarkan oleh Admin desa.
                    </div>
                </form>
            </div>

            <!-- Panel Hasil Pencarian (Otomatis Muncul Jika Data Ditemukan) -->
            @if(isset($pelanggan) && isset($tagihan))
                <div class="card border-0 shadow portal-card overflow-hidden mb-4">
                    <div class="card-header bg-primary text-white text-center py-3 fw-bold text-uppercase tracking-wide">
                        Detail Informasi Tagihan Air Anda
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Nama Warga / Kepala Keluarga</small>
                                <span class="fw-bold text-dark fs-5">{{ $pelanggan->nama }}</span>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">No. Pelanggan</small>
                                <span class="fw-bold text-primary fs-5">{{ $pelanggan->no_pelanggan }}</span>
                            </div>
                            <div class="col-11">
                                <small class="text-muted d-block">Alamat Rumah</small>
                                <span class="fw-semibold text-secondary">{{ $pelanggan->alamat }}</span>
                            </div>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered align-middle text-center small mb-0">
                                <thead class="table-light fw-bold text-uppercase">
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Meteran Lalu</th>
                                        <th>Meteran Baru</th>
                                        <th>Pemakaian</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-secondary">
                                    <tr>
                                        <td class="text-dark text-uppercase font-bold">{{ $tagihan->bulan }} / {{ $tagihan->tahun }}</td>
                                        <td>{{ $tagihan->meteran_lalu }} M³</td>
                                        <td>{{ $tagihan->meteran_baru }} M³</td>
                                        <td class="text-primary fw-bold">{{ $tagihan->total_kubik }} M³</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Panel Detail Pembayaran & Status -->
                        <div class="p-3 bg-light rounded-3 mb-4 d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block fw-semibold">TOTAL YANG HARUS DIBAYAR</small>
                                <span class="fs-4 fw-bold text-danger">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                @if($tagihan->status == 'belum_bayar')
                                    <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold">🛑 Belum Bayar</span>
                                @elseif($tagihan->status == 'menunggu_verifikasi')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">⏳ Menunggu Validasi</span>
                                @elseif($tagihan->status == 'lunas')
                                    <span class="badge bg-success px-3 py-2 rounded-pill fw-bold">✓ Lunas / Selesai</span>
                                @else
                                    <span class="badge bg-dark px-3 py-2 rounded-pill fw-bold">✕ Pembayaran Ditolak</span>
                                @endif
                            </div>
                        </div>

                        <!-- Form Upload Bukti Transfer (Hanya Tampil Jika Belum Bayar / Ditolak) -->
                        @if($tagihan->status == 'belum_bayar' || $tagihan->status == 'ditolak')
                            <div class="border p-3 rounded-3 bg-white shadow-sm">
                                <h6 class="fw-bold text-dark mb-2">💳 Konfirmasi Pembayaran Via Transfer</h6>
                                <p class="text-muted small mb-3">Silakan transfer ke rekening desa **Bank Nagari 1234-5678-90** lalu unggah foto struk bukti transfernya di bawah ini:</p>
                                
                                <form action="{{ route('warga.bayar', $tagihan->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="file" name="bukti_transfer" class="form-control" accept="image/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm" style="border-radius: 8px;">
                                        📤 Kirim Bukti Pembayaran
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- Pesan Jika Sudah Lunas -->
                        @if($tagihan->status == 'lunas')
                            <div class="alert alert-success border-0 shadow-sm text-center fw-medium m-0">
                                🎉 Terima kasih! Iuran air bersih Anda bulan ini telah divalidasi dan dinyatakan lunas.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Footer Hak Cipta -->
            <div class="text-center text-muted small mt-5">
                &copy; {{ date('Y') }} Sistem Informasi PAMSIMAS. All Rights Reserved.
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>