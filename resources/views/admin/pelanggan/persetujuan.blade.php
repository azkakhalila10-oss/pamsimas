@extends('layouts.admin_master')

@section('title', 'Validasi Warga Baru')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
    <!-- Header dengan style modern -->
    <div class="card-header bg-white py-4 border-0 border-bottom">
        <h5 class="m-0 fw-bold text-dark text-uppercase tracking-wide">
            <i class="fa-solid fa-bell text-warning me-2"></i> Daftar Pendaftaran Warga Baru
        </h5>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-uppercase text-secondary" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                        <th class="ps-4 py-3">Nama Lengkap</th>
                        <th class="py-3">No HP / WhatsApp</th>
                        <th class="py-3">Alamat</th>
                        <th class="text-center py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($wargaPending as $w)
                    <tr class="border-bottom">
                        <td class="ps-4 py-3">
                            <div class="fw-bold text-dark">{{ $w->nama }}</div>
                            <small class="text-muted">ID: {{ $w->id }}</small>
                        </td>
                        <td class="py-3">{{ $w->no_hp }}</td>
                        <td class="py-3">{{ $w->alamat }}</td>
                        <td class="text-center py-3">
                            <form action="{{ route('admin.pelanggan.setujui', $w->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm px-3 shadow-sm fw-bold" style="border-radius: 6px;">
                                    <i class="fa-solid fa-check me-1"></i> Setujui
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-box-open fs-2 mb-2 d-block opacity-50"></i>
                            Tidak ada pendaftaran baru yang menunggu.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection