@extends('layouts.admin_master')

@section('efek_halaman', 'efek-naik')

@section('title', 'Validasi Pembayaran iuran')

@section('content')
<div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(8px); border-radius: 12px; overflow: hidden;">
    <div class="card-header bg-dark py-3 border-0 text-center text-white fw-bold text-uppercase tracking-wide" style="background-color: #0f172a !important;">
        PANEL VERIFIKASI & VALIDASI PEMBAYARAN WARGA
    </div>
    
    <div class="card-body p-4">
        <div class="text-secondary small fw-semibold mb-4">
            Periksa lampiran struk transfer warga dengan teliti sebelum menekan tombol konfirmasi lunas atau gunakan tombol tunai jika warga membayar langsung.
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
                        <th class="text-start">Nama Warga</th>
                        <th>Bulan Tagihan</th>
                        <th>Total Iuran</th>
                        <th>Status Sistem</th>
                        <th>Bukti Struk</th>
                        <th style="width: 25%;">Tindakan Admin</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.85rem; font-weight: 500;" class="text-secondary">
                    @forelse($daftarTagihan as $index => $t)
                        @php
                            $namaWarga = '-';
                            if (isset($t->pelanggan)) {
                                $namaWarga = is_array($t->pelanggan) ? ($t->pelanggan['nama'] ?? 'Warga Terhapus') : ($t->pelanggan->nama ?? 'Warga Terhapus');
                            }

                            $buktiTransfer = null;
                            if (isset($t->pembayaran) && $t->pembayaran) {
                                $buktiTransfer = is_array($t->pembayaran) ? ($t->pembayaran['bukti_transfer'] ?? null) : ($t->pembayaran->bukti_transfer ?? null);
                            }
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-start text-dark fw-semibold">{{ $namaWarga }}</td>
                            <td class="text-uppercase">{{ $t->bulan ?? '-' }}</td>
                            <td class="fw-bold text-dark">Rp {{ number_format($t->total_tagihan ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @if(($t->status ?? '') == 'menunggu_verifikasi')
                                    <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-1.5 rounded-pill fw-bold">⏳ Menunggu Validasi</span>
                                @elseif(($t->status ?? '') == 'lunas')
                                    <span class="badge bg-success-subtle text-success border border-success px-3 py-1.5 rounded-pill fw-bold">✓ Lunas</span>
                                @elseif(($t->status ?? '') == 'ditolak')
                                    <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1.5 rounded-pill fw-bold">✗ Ditolak</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-1.5 rounded-pill fw-bold">🛑 Belum Bayar</span>
                                @endif
                            </td>
                            <td>
                                @if($buktiTransfer)
                                    @if($buktiTransfer == 'BAYAR_CASH_LANGSUNG.png')
                                        <span class="text-success small fw-bold">💵 Tunai / Cash</span>
                                    @else
                                        <a href="{{ asset('uploads/bukti_bayar/' . $buktiTransfer) }}" target="_blank" class="btn btn-sm btn-light border fw-semibold text-primary" style="font-size: 0.75rem;">
                                            📂 Lihat Struk
                                        </a>
                                    @endif
                                @else
                                    <span class="text-muted small"><em>Belum upload</em></span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    @if(($t->status ?? '') == 'belum_bayar')
                                        <form action="{{ route('admin.tagihan.cash', $t->id) }}" method="POST" onsubmit="return confirm('Apakah warga ini benar-benar membayar tunai di tempat?')" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary fw-bold d-flex align-items-center gap-1 shadow-sm px-2.5 py-1.5" style="border-radius: 6px;">
                                                💵 Bayar Cash
                                            </button>
                                        </form>
                                    @endif

                                    @if(($t->status ?? '') == 'menunggu_verifikasi')
                                        <form action="{{ route('admin.tagihan.lunas', $t->id) }}" method="POST" onsubmit="return confirm('Apakah iuran warga ini benar-benar sudah masuk rekening?')" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success fw-bold px-2.5 py-1.5" style="border-radius: 6px;">✓ Setujui</button>
                                        </form>

                                        <form action="{{ route('admin.tagihan.tolak', $t->id) }}" method="POST" onsubmit="return confirm('Tolak bukti pembayaran warga ini?')" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger fw-bold px-2.5 py-1.5" style="border-radius: 6px;">✕ Tolak</button>
                                        </form>
                                    @endif

                                    @if(($t->status ?? '') == 'lunas')
                                        <a href="{{ route('admin.tagihan.cetak', $t->id) }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold px-3 py-1.5" style="border-radius: 6px;">
                                            🖨 Cetak Nota
                                        </a>
                                    @endif

                                    <!-- Form Hapus yang sudah diperbaiki variabelnya menjadi $t->id -->
                                    <form action="{{ route('admin.tagihan.destroy', $t->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE') 
                                        <button type="submit" class="btn btn-danger btn-sm fw-bold px-2.5 py-1.5" style="border-radius: 6px;" onclick="return confirm('Yakin ingin menghapus tagihan ini?')">
                                         🗑️ Hapus
                                        </button>
                                    </form>
                                    <!-- Tag penutup ekstra yang nyasar sudah dibuang -->

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted fw-medium">
                                Bersih! Belum ada antrean pembayaran iuran air yang masuk saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection