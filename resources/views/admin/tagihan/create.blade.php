@extends('layouts.admin_master')

@section('title', 'Catat Meteran Air Bulanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px);">
            <!-- Header Card -->
            <div class="card-header bg-dark py-3 border-0 text-center text-white fw-bold text-uppercase tracking-wide" style="background-color: #0f172a !important;">
                FORM PENCATATAN METERAN AIR WARGA
            </div>
            
            <div class="card-body p-4 p-md-5">
                <div class="text-secondary small fw-medium mb-4 text-center">
                    Masukkan angka meteran air terbaru dengan teliti. Sistem akan otomatis menghitung selisih kubik dan total tarif iuran secara otomatis.
                </div>

                <!-- Notifikasi Eror (Jika Ada) -->
                @if(session('error'))
                    <div class="alert alert-danger shadow-sm fw-bold mb-4">⚠️ {{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success shadow-sm fw-bold mb-4">✓ {{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.tagihan.store') }}" method="POST">
                    @csrf
                    
                    <!-- 1. Pilih Warga / Pelanggan Menggunakan NIK + FITUR CARI KETIK -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">Pilih Kepala Keluarga / Warga</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-user"></i></span>
                            <!-- FIX: Menghapus atribut 'required' agar tidak bentrok dengan Select2 -->
                            <select name="pelanggan_id" class="form-select pilih-warga-cari @error('pelanggan_id') is-invalid @enderror">
                                <option value="">-- Ketik Nama atau NIK Warga --</option>
                                @foreach($daftarPelanggan as $p)
                                    <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama }} (NIK: {{ $p->NIK ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('pelanggan_id')
                            <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- 2. Bulan dan Tahun -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Bulan Periode</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-calendar-days"></i></span>
                                <select name="bulan" class="form-select text-uppercase fw-medium">
                                    @foreach(['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'] as $b)
                                        <option value="{{ $b }}" {{ old('bulan', strtolower(date('F'))) == $b ? 'selected' : '' }}>{{ $b }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label small fw-bold text-dark">Tahun</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-calendar"></i></span>
                                <select name="tahun" class="form-select fw-medium">
                                    @for($i = date('Y')-1; $i <= date('Y')+1; $i++)
                                        <option value="{{ $i }}" {{ old('tahun', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Angka Meteran Bulan Ini -->
                    <div class="mb-5">
                        <label class="form-label small fw-bold text-dark">Angka Meteran Bulan Ini (M³)</label>
                        <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                            <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-gauge-high"></i></span>
                            <input type="number" name="meteran_baru" class="form-control p-2.5 @error('meteran_baru') is-invalid @enderror" placeholder="Contoh: 124" value="{{ old('meteran_baru') }}" required style="font-size: 0.95rem;">
                            <span class="input-group-text bg-light text-dark fw-bold">M³</span>
                        </div>
                        @error('meteran_baru')
                            <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TOMBOL ACTION -->
                    <div class="d-flex gap-3">
                        <a href="{{ route('admin.tagihan.index') }}" class="btn btn-light border fw-semibold p-2.5 flex-grow-1 text-center text-decoration-none" style="border-radius: 8px;">
                            ❌ Batal
                        </a>
                        <button type="submit" class="btn btn-primary fw-bold p-2.5 flex-grow-1" style="border-radius: 8px; background-color: #2563eb; border: none;">
                            💾 Simpan Rekaman Meteran
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection