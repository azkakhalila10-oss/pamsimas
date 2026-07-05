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
        // Validasi form
        $request->validate([
            'pelanggan_id' => 'required', 
            'meteran_baru' => 'required|numeric',
            'bulan' => 'required',
            'tahun' => 'required'
        ]);
        
        $last = Tagihan::where('pelanggan_id', $request->pelanggan_id)
                        ->orderBy('id', 'desc')
                        ->first();
                        
        $meteranLalu = $last ? $last->meteran_baru : 0;
        
        // Pastikan meteran baru masuk akal
        if ($request->meteran_baru < $meteranLalu) {
            return back()->with('error', 'Meteran baru tidak boleh lebih kecil dari meteran lalu!');
        }

        Tagihan::create([
            'pelanggan_id' => $request->pelanggan_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'meteran_lalu' => $meteranLalu,
            'meteran_baru' => $request->meteran_baru,
            'total_kubik' => $request->meteran_baru - $meteranLalu,
            'total_tagihan' => (($request->meteran_baru - $meteranLalu) * 2500) + 10000,
            'status' => 'belum_bayar'
        ]);

        return redirect()->route('admin.tagihan.index')->with('success', 'Data tagihan berhasil disimpan!');
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