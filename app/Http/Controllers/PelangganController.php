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
        $daftarPelanggan = Pelanggan::where('NIK', 'NOT LIKE', '999%')->orderBy('nama', 'asc')->get();
        return view('admin.pelanggan.index', compact('daftarPelanggan'));
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NIK' => 'required',
            'nama' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            $pesanError = implode(', ', $validator->errors()->all());
            return redirect()->back()->withInput()->with('error', 'Form belum lengkap: ' . $pesanError);
        }

        try {
            $warga = new Pelanggan();
            $warga->NIK = $request->NIK; 
            $warga->nama = $request->nama;
            $warga->no_hp = $request->no_hp;
            $warga->alamat = $request->alamat;
            $warga->save();

            return redirect()->route('admin.pelanggan.index')->with('success', 'Warga baru berhasil didaftarkan ke sistem!');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan ke database: ' . $e->getMessage());
        }
    }

    public function persetujuan()
    {
        $wargaPending = Pelanggan::where('NIK', 'LIKE', '999%')->orderBy('created_at', 'desc')->get();
        return view('admin.pelanggan.persetujuan', compact('wargaPending'));
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
        
        // Hapus tagihan terkait di database asli agar tidak bentrok
        Tagihan::where('pelanggan_id', $id)->delete();
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
            $warga->NIK = '999' . rand(10000000000000, 99999999999999); 
            $warga->no_pelanggan = 'PLG-' . rand(1000, 9999); 
            $warga->nama = $request->nama;
            $warga->no_hp = $request->no_hp;
            $warga->alamat = $request->alamat;
            $warga->save();

            return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu konfirmasi Admin.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mendaftar: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // FITUR CEK DAN BAYAR TAGIHAN (SUDAH TERKONEKSI KE DATABASE ASLI!)
    // =========================================================================

    public function cekTagihan()
    {
        return view('warga.cek_tagihan');
    }

    public function cariTagihan(Request $request)
    {
        $request->validate(['pencarian' => 'required']);
        
        // Cari pelanggan langsung dari database
        $pelanggan = Pelanggan::where('nama', 'LIKE', '%' . $request->pencarian . '%')->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data warga tidak ditemukan! Periksa kembali ejaan nama Anda.');
        }

        // Ambil tagihan terbaru milik pelanggan tersebut dari database
        $tagihan = Tagihan::where('pelanggan_id', $pelanggan->id)->orderBy('id', 'desc')->first();

        if (!$tagihan) {
            return redirect()->back()->with('error', 'Tagihan untuk warga bernama ' . $pelanggan->nama . ' belum diterbitkan.');
        }

        return view('warga.cek_tagihan', ['pelanggan' => $pelanggan, 'tagihan' => $tagihan]);
    }

    public function bayar(Request $request, $id)
    {
        $request->validate(['bukti_transfer' => 'required|image|max:2048']);
        $tagihan = Tagihan::findOrFail($id);

        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $namaFile = 'bukti_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bukti_bayar'), $namaFile);

            // Simpan bukti ke database Pembayaran
            Pembayaran::create([
                'tagihan_id' => $tagihan->id,
                'tgl_bayar' => now(),
                'bukti_transfer' => $namaFile,
            ]);

            // Ubah status tagihan di database
            $tagihan->update(['status' => 'menunggu_verifikasi']);

            return redirect()->back()->with('success', 'Bukti transfer berhasil dikirim! Silakan tunggu verifikasi admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }
}