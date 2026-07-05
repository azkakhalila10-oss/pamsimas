@extends('layouts.admin_master')

@section('title', 'Catat Meteran Air')

@section('content')
<!-- Panggil Library Pencarian di Sini Agar Tidak Diblokir -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="container-fluid px-3 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header py-4 text-center border-0" style="background-color: #111827; color: #ffffff;">
                    <h5 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">Form Pencatatan Meteran Air Warga</h5>
                </div>
                
                <div class="card-body p-4 p-md-5 bg-white">
                    <p class="text-center text-muted mb-5 px-3">
                        Masukkan angka meteran air terbaru dengan teliti. Sistem akan otomatis menghitung selisih kubik dan total tarif iuran secara otomatis.
                    </p>

                    @if(session('error'))
                        <div class="alert alert-danger rounded-3 shadow-sm mb-4 border-0 border-start border-danger border-4">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.tagihan.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Pilih Kepala Keluarga / Warga</label>
                            
                            <!-- IKON DIKEMBALIKAN KE SINI -->
                            <div class="input-group input-group-lg shadow-sm rounded-3">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                                
                                <select name="pelanggan_id" id="cariWarga" class="form-control border-0 bg-light" required>
                                    <option value="">-- Ketik Nama atau NIK Warga --</option>
                                    @foreach($daftarPelanggan as $warga)
                                        <option value="{{ $warga->id }}">{{ $warga->nama }} (NIK: {{ $warga->NIK }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-5 mt-4">
                            <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Angka Meteran Bulan Ini (M³)</label>
                            <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-gauge-high text-muted"></i></span>
                                <input type="number" name="meteran_sekarang" class="form-control border-0 bg-light fs-6" required placeholder="Contoh: 124">
                                <span class="input-group-text bg-light border-0 fw-bold text-secondary">M³</span>
                            </div>
                        </div>

                        <hr class="text-muted my-4" style="opacity: 0.15;">

                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('admin.tagihan.index') }}" class="btn btn-light px-4 py-2 fw-bold text-secondary rounded-3 border-0 shadow-sm">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-3 shadow-sm border-0" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Catatan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Gaya Tambahan Agar Kotak Pencarian Rapi dan Menyatu -->
<style>
    /* Penting agar kotak search tidak gepeng di dalam input-group */
    .select2-container {
        flex: 1 1 auto; 
    }
    /* Membuang garis tepi (border) bawaan Select2 */
    .select2-container--default .select2-selection--single {
        background-color: #f8f9fa !important;
        border: none !important;
        height: 100% !important;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        outline: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-left: 0 !important;
        color: #495057;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 25% !important;
    }
</style>

<!-- Aktifkan Pencarian Secara Paksa -->
<script>
    $(document).ready(function() {
        $('#cariWarga').select2({
            placeholder: "-- Ketik Nama atau NIK Warga --",
            allowClear: true
        });
    });
</script>
@endsection