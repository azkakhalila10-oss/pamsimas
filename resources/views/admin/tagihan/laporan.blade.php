@extends('layouts.admin_master')

@section('title', 'Laporan Bulanan PAMSIMAS')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px; background: #fff;">
    <div class="card-body p-5">
        
        <!-- Header Laporan -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: 1px;">LAPORAN BULANAN IURAN AIR PAMSIMAS</h2>
            <h4 class="text-secondary mb-3">KORONG PADANG LARIANG BARAT</h4>
            <span class="text-muted fw-bold" style="letter-spacing: 1px;">
                PERIODE: {{ strtoupper(\Carbon\Carbon::now()->translatedFormat('F / Y')) }}
            </span>
        </div>

        <hr class="mb-4">

        <!-- Card Ringkasan Keuangan -->
        <div class="row mb-4">
            <!-- Card Pemasukan -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-0 border-start border-success border-4 h-100">
                    <div class="card-body">
                        <p class="text-muted fw-bold mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">TOTAL PENDAPATAN (LUNAS)</p>
                        <h2 class="text-success fw-bold mb-0">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
            
            <!-- Card Tunggakan -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-0 border-start border-danger border-4 h-100">
                    <div class="card-body">
                        <p class="text-muted fw-bold mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">TOTAL TUNGGAKAN (BELUM BAYAR)</p>
                        <h2 class="text-danger fw-bold mb-0">Rp {{ number_format($totalTunggakan ?? 0, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive mb-5">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="text-white text-uppercase" style="background-color: #1e293b; font-size: 0.8rem; letter-spacing: 1px;">
                    <tr>
                        <th class="py-3">No</th>
                        <th class="py-3 text-start">Nama Warga</th>
                        <th class="py-3">Bulan / Tahun</th>
                        <th class="py-3">Pemakaian</th>
                        <th class="py-3">Total Tagihan</th>
                        <th class="py-3">Metode</th>
                        <th class="py-3">Status</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.9rem;">
                    @forelse($daftarTagihan as $index => $t)
                        <tr>
                            <td class="text-muted">{{ $index + 1 }}</td>
                            <td class="text-start fw-bold text-dark">{{ $t->pelanggan->nama ?? '-' }}</td>
                            <td class="text-uppercase">{{ $t->bulan ?? '-' }} / {{ $t->tahun ?? '-' }}</td>
                            <td class="text-muted">{{ $t->jumlah_meter ?? $t->pemakaian ?? 0 }} m³</td>
                            <td class="fw-bold">Rp {{ number_format($t->total_tagihan ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <!-- KODE METODE PEMBAYARAN DISEDERHANAKAN AGAR TIDAK ERROR -->
                                @if(strtolower($t->status) == 'lunas')
                                    <span class="text-success fw-bold">Sudah Bayar</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if(strtolower($t->status) == 'lunas')
                                    <span class="badge bg-success px-3 py-2">Lunas</span>
                                @elseif(strtolower($t->status) == 'menunggu_verifikasi')
                                    <span class="badge bg-warning text-dark px-3 py-2">Menunggu</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">Belum Bayar</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5" style="background-color: #f8fafc;">
                                Tidak ada rekaman data transaksi iuran air pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bagian Tanda Tangan (Footer) -->
        <div class="row mt-4">
            <div class="col-8">
                <!-- Tombol Print (Sembunyi otomatis saat di-print) -->
                <button onclick="window.print()" class="btn btn-primary d-print-none px-4 shadow-sm">
                    <i class="fa-solid fa-print me-2"></i> Cetak Dokumen Laporan
                </button>
            </div>
            <div class="col-4 text-center">
                <p class="text-muted mb-5">Padang Lariang Barat, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                <p class="fw-bold mb-0 text-dark">Koordinator PAMSIMAS</p>
            </div>
        </div>

    </div>
</div>

<!-- CSS Tambahan agar rapi saat masuk ke mode Printer (Kertas) -->
<style>
    @media print {
        body { background-color: #fff !important; }
        nav, aside, header, .sidebar, .navbar { display: none !important; } 
        .content { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .card { box-shadow: none !important; border: none !important; }
    }
</style>
@endsection