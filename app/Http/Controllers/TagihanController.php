<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Pembayaran;

class TagihanController extends Controller
{
    public function dashboard()
    {
        // 1. Menghitung total data
        $totalPelanggan = Pelanggan::count();
        
        $totalTagihanBulanIni = Tagihan::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year) // Sangat bagus! Tambahan year agar akurat
                                        ->sum('total_tagihan');

        // 2. [PENTING] Mengembalikan variabel ini agar view dashboard tidak error "Undefined Variable"
        $menungguVerifikasi = Tagihan::where('status', 'menunggu_verifikasi')->count();
        $pelangganTerbaru = Pelanggan::orderBy('id', 'desc')->take(5)->get();
        
        return view('admin.dashboard', compact('totalPelanggan', 'totalTagihanBulanIni', 'menungguVerifikasi', 'pelangganTerbaru'));
    }

    public function create()
    {
        $daftarPelanggan = Pelanggan::orderBy('nama', 'asc')->get(); // Diurutkan sesuai abjad nama
        return view('admin.tagihan.create', compact('daftarPelanggan'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Inputan Admin (nama input di HTML tetap 'meteran_sekarang')
        $request->validate([
            'pelanggan_id' => 'required',
            'meteran_sekarang' => 'required|numeric|min:0',
        ]);

        try {
            // 2. Cari angka meteran bulan lalu dari warga ini
            $tagihanTerakhir = Tagihan::where('pelanggan_id', $request->pelanggan_id)
                                      ->orderBy('id', 'desc')
                                      ->first();

            // Sesuaikan dengan nama kolom di database:
            $meteran_lalu = $tagihanTerakhir ? $tagihanTerakhir->meteran_baru : 0;
            $meteran_baru = $request->meteran_sekarang;

            // 3. Mencegah Admin salah ketik (angka baru tidak boleh lebih kecil dari lama)
            if ($meteran_baru < $meteran_lalu) {
                return redirect()->back()->with('error', 'Gagal! Angka meteran terbaru tidak boleh lebih kecil dari meteran bulan lalu ('.$meteran_lalu.' M³).');
            }

            // 4. MENGHITUNG TOTAL TAGIHAN (Sesuai Aturan PAMSIMAS)
            $total_kubik = $meteran_baru - $meteran_lalu; 
            $tarif_per_kubik = 2000;
            $beban_tetap = 5000;

            $total_tagihan = ($total_kubik * $tarif_per_kubik) + $beban_tetap;

            // 5. Simpan ke Database (Nama kolom sudah 100% sama dengan Migration)
            Tagihan::create([
                'pelanggan_id' => $request->pelanggan_id,
                'bulan' => date('m'), // Mengambil angka bulan saat ini secara otomatis
                'tahun' => date('Y'), // Mengambil angka tahun saat ini secara otomatis
                'meteran_lalu' => $meteran_lalu,
                'meteran_baru' => $meteran_baru,
                'total_kubik' => $total_kubik,
                'total_tagihan' => $total_tagihan,
                'status' => 'belum_bayar', 
            ]);

            // Format angka menjadi bentuk Rupiah untuk ditampilkan
            $rupiah = 'Rp ' . number_format($total_tagihan, 0, ',', '.');

            return redirect()->route('admin.tagihan.index')
                             ->with('success', 'Catatan berhasil disimpan! Total tagihan warga ini adalah ' . $rupiah);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
    public function index()
    {
        // Ditambah orderBy agar tagihan terbaru selalu tampil di baris paling atas tabel
        $daftarTagihan = \App\Models\Tagihan::with('pelanggan')->orderBy('created_at', 'desc')->get();
        
        // PERBAIKAN: Menambahkan return view agar tabel Daftar Tagihannya mau muncul
        return view('admin.tagihan.index', compact('daftarTagihan'));
    }

    public function konfirmasiLunas($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update(['status' => 'lunas']);
        
        return back()->with('success', 'Pembayaran berhasil divalidasi menjadi Lunas!');
    }

    // =========================================================================
    // FITUR CETAK TAGIHAN
    // =========================================================================
    public function cetak($id)
    {
        // Cari data tagihan berdasarkan ID, beserta data pelanggan yang terkait
        $tagihan = \App\Models\Tagihan::with('pelanggan')->findOrFail($id);

        // Arahkan ke file tampilan cetak.blade.php dengan membawa data tagihan
        return view('admin.tagihan.cetak', compact('tagihan'));
    }
    
    // =========================================================================
    // FITUR LAPORAN BULANAN (Kembarannya sudah dihapus, sisa yang benar ini)
    // =========================================================================
    public function laporan(Request $request)
    {
        // 1. Ambil data tagihan beserta data pelanggan
        $daftarTagihan = \App\Models\Tagihan::with('pelanggan')->orderBy('created_at', 'desc')->get();

        // 2. Hitung otomatis Total Pendapatan (Lunas)
        $totalPendapatan = $daftarTagihan->where('status', 'lunas')->sum('total_tagihan');
        
        // 3. Hitung otomatis Total Tunggakan (Belum Bayar & Menunggu Verifikasi)
        $totalTunggakan = $daftarTagihan->whereIn('status', ['belum_bayar', 'menunggu_verifikasi'])->sum('total_tagihan');

        // 4. Kirim data ke halaman view
        return view('admin.tagihan.laporan', compact('daftarTagihan', 'totalPendapatan', 'totalTunggakan'));
    }
    
    // =========================================================================
    // FITUR HAPUS TAGIHAN (Tambahan agar tombol hapusmu tidak memunculkan error)
    // =========================================================================
    public function destroy($id)
    {
        $tagihan = \App\Models\Tagihan::findOrFail($id);
        $tagihan->delete();
        
        return back()->with('success', 'Tagihan berhasil dihapus dari sistem!');
    }
}