@extends('layouts.admin_master')

<!-- Menentukan efek transisi geser dari kiri khusus halaman data warga -->
@section('efek_halaman', 'efek-kiri')

@section('title', 'Data Warga / Pelanggan')

@section('content')
<div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(8px); border-radius: 12px; overflow: hidden;">
    <div class="card-header bg-dark py-3 border-0 text-center text-white fw-bold text-uppercase tracking-wide" style="background-color: #0f172a !important;">
        DAFTAR MASTER DATA WARGA / PELANGGAN PAMSIMAS
    </div>
    
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="text-secondary small fw-semibold">
                Manajemen data profil seluruh kepala keluarga yang terdaftar sebagai pengguna layanan air bersih.
            </div>
            <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary btn-sm fw-bold px-3 py-2 shadow-sm" style="border-radius: 8px; background-color: #2563eb; border: none;">
                ➕ Tambah Warga Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm fw-medium mb-4">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger shadow-sm fw-medium mb-4">✗ {{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center border">
                <thead class="table-light text-uppercase tracking-wider" style="font-size: 0.75rem;">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>NIK</th> <!-- Kolom NIK Warga -->
                        <th class="text-start">Nama Kepala Keluarga</th>
                        <th>No. Handphone</th>
                        <th class="text-start">Alamat Rumah</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.85rem; font-weight: 500;" class="text-secondary">
                    @forelse($daftarPelanggan as $index => $pelanggan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <!-- FIX TOTAL SAKTI: Memanggil kolom NIK huruf kapital dari variabel $pelanggan -->
                            <td>
                                <span class="badge bg-dark-subtle text-dark border px-2.5 py-1.5 fw-bold" style="font-size: 0.75rem;">
                                    {{ $pelanggan->NIK ?? 'KOSONG' }}
                                </span>
                            </td>
                            <td class="text-start text-dark fw-bold">{{ $pelanggan->nama }}</td>
                            <td>{{ $pelanggan->no_hp ?? '-' }}</td>
                            <td class="text-start text-capitalize">{{ $pelanggan->alamat }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <!-- Tombol Hapus Data Warga Dari Database -->
                                    <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga {{ $pelanggan->nama }} permanen dari sistem?')" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1 shadow-sm px-2.5 py-1.5" style="border-radius: 6px; font-size: 0.8rem;">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted fw-medium">
                                Belum ada data warga desa yang terdaftar di database saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection