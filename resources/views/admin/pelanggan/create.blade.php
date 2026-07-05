<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    // =========================================================================
    // [ADMIN] FITUR DAN KELOMPOK MENU ADMIN
    // =========================================================================

    public function index()
    {
        $daftarPelanggan = Pelanggan::whereNotNull('NIK')
            ->where('NIK', '!=', '')
            ->orderBy('nama', 'asc')
            ->get();
            
        return view('admin.pelanggan.index', compact('daftarPelanggan'));
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    // FITUR SIMPAN YANG SUDAH DI-BYPASS VALIDASINYA AGAR TIDAK MACET
    public function store(Request $request)
    {
        // 1. Validasi Manual
        $validator = Validator::make($request->all(), [
            'NIK' => 'required',
            'nama' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        // 2. Cegah refresh diam-diam, lempar pesan eror ke kotak merah HTML
        if ($validator->fails()) {
            $pesanError = implode(', ', $validator->errors()->all());
            return redirect()->back()->withInput()->with('error', 'Form belum lengkap: ' . $pesanError);
        }

        // 3. Simpan ke Database
        try {
            $warga = new Pelanggan();
            $warga->NIK = $request->NIK; 
            $warga->nama = $request->nama;
            $warga->no_hp = $request->no_hp;
            $warga->alamat = $request->alamat;
            $warga->save();

            return redirect()->route('admin.pelanggan.index')->with('success', 'Warga baru berhasil didaftarkan ke sistem!');
            
        } catch (\Exception $e) {
            // Tangkap eror MySQL (misal: NIK sudah ada, atau kolom NIK kependekan)
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan ke database: ' . $e->getMessage());
        }
    }

    public function setujui(Request $request, $id)
    {
        try {
            $warga = Pelanggan::findOrFail($id);
            $warga->NIK = $request->NIK ?? '13456' . rand(1000000000, 9999999999); 
            $warga->save();

            return redirect()->route('admin.pelanggan.index')->with('success', 'Data warga ' . $warga->nama . ' berhasil disetujui dan telah aktif!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $sessionTagihan = session('mock_tagihan', []);
        
        foreach ($sessionTagihan as $key => $value) {
            if (isset($value['pelanggan_id']) && $value['pelanggan_id'] == $id) {
                unset($sessionTagihan[$key]);
            }
        }
        session(['mock_tagihan' => $sessionTagihan]);
        $pelanggan->delete();

        return redirect()->back()->with('success', 'Data warga berhasil dihapus!');
    }


    // =========================================================================
    // [WARGA] FITUR PENDAFTARAN MANDIRI & PORTAL DEPAN (VIA HP)
    // =========================================================================

    public function registerWarga()
    {
        return view('auth.register_warga');
    }

    public function storeRegisterWarga(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'no_hp' => 'required',
                'alamat' => 'required',
            ]);

            $warga = new Pelanggan();
            $warga->NIK = null; 
            $warga->nama = $request->nama;
            $warga->no_hp = $request->no_hp;
            $warga->alamat = $request->alamat;
            $warga->save();

            return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu konfirmasi Admin.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mendaftar: ' . $e->getMessage());
        }
    }

    public function cekTagihan()
    {
        return view('warga.cek_tagihan');
    }

    public function cariTagihan(Request $request)
    {
        $request->validate(['pencarian' => 'required']);
        $pelanggan = Pelanggan::where('nama', 'LIKE', '%' . $request->pencarian . '%')->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data warga tidak ditemukan! Periksa kembali ejaan nama Anda.');
        }

        $sessionTagihan = session('mock_tagihan', []);
        $tagihanData = collect($sessionTagihan)->where('pelanggan_id', $pelanggan->id)->sortByDesc('id')->first();

        if (!$tagihanData) {
            return redirect()->back()->with('error', 'Tagihan untuk warga bernama ' . $pelanggan->nama . ' belum diterbitkan.');
        }

        $tagihan = json_decode(json_encode($tagihanData));
        $pelangganObj = isset($tagihan->pelanggan) ? $tagihan->pelanggan : $pelanggan;

        return view('warga.cek_tagihan', ['pelanggan' => $pelangganObj, 'tagihan' => $tagihan]);
    }

    public function bayar(Request $request, $id)
    {
        $request->validate(['bukti_transfer' => 'required|image|max:2048']);
        $tagihan = Tagihan::find($id);

        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $namaFile = 'bukti_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bukti_bayar'), $namaFile);

            if ($tagihan) {
                Pembayaran::create([
                    'tagihan_id' => $tagihan->id,
                    'tgl_bayar' => now(),
                    'bukti_transfer' => $namaFile,
                ]);
                $tagihan->update(['status' => 'menunggu_verifikasi']);
            }

            $sessionTagihan = session('mock_tagihan', []);
            if (isset($sessionTagihan[$id])) {
                $sessionTagihan[$id]['status'] = 'menunggu_verifikasi';
                $sessionTagihan[$id]['pembayaran'] = [
                    'id' => rand(100, 999),
                    'tagihan_id' => $id,
                    'bukti_transfer' => $namaFile,
                    'tgl_bayar' => now()->format('Y-m-d H:i:s')
                ];
                session(['mock_tagihan' => $sessionTagihan]);
            }

            return redirect()->back()->with('success', 'Bukti transfer berhasil dikirim!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }
}