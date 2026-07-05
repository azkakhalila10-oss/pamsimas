@extends('layouts.admin_master')

@section('title', 'Tambah Warga PAMSIMAS')

@section('content')
<div class="container-fluid px-3 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6"> 
            
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-4 px-4 border-0 text-center" style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-user-plus me-2"></i>Form Pendaftaran Warga Baru</h5>
                </div>
                
                <div class="card-body p-4 p-md-5 bg-white">
                    @if(session('error'))
                        <div class="alert alert-danger rounded-3 shadow-sm mb-4 border-0 border-start border-danger border-4">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.pelanggan.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4"> 
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Nomor Induk Kependudukan</label>
                                <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="fa-regular fa-id-card text-muted"></i></span>
                                    <input type="number" name="NIK" class="form-control border-0 bg-light fs-6" required placeholder="Masukkan NIK valid" value="{{ old('NIK') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Nama Lengkap</label>
                                <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="fa-regular fa-user text-muted"></i></span>
                                    <input type="text" name="nama" class="form-control border-0 bg-light fs-6" required placeholder="Sesuai KTP" value="{{ old('nama') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Nomor HP / WhatsApp</label>
                                <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="fa-brands fa-whatsapp text-muted"></i></span>
                                    <input type="number" name="no_hp" class="form-control border-0 bg-light fs-6" required placeholder="Contoh: 081234567890" value="{{ old('no_hp') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Alamat Lengkap</label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0 align-items-start pt-3"><i class="fa-solid fa-map-location-dot text-muted"></i></span>
                                    <textarea name="alamat" class="form-control border-0 bg-light" rows="3" required placeholder="Detail alamat di Korong Padang Lariang Barat">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="text-muted my-5" style="opacity: 0.15;">

                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-light px-4 py-2 fw-bold text-secondary rounded-3 border-0 shadow-sm">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-3 shadow-sm border-0" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        box-shadow: none;
        background-color: #fff !important;
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        background-color: #fff;
    }
    .input-group:focus-within .input-group-text, 
    .input-group:focus-within .form-control {
        background-color: #fff !important;
    }
</style>
@endsection