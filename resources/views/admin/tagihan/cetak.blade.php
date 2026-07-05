<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran PAMSIMAS</title>
    <style>
        /* Desain ala kertas Thermal Kasir Minimarket */
        body {
            background-color: #e0e0e0; 
            font-family: 'Courier New', Courier, monospace; 
            font-size: 12px;
            color: #000;
        }
        .struk-container {
            width: 300px; 
            background-color: #fff; 
            margin: 20px auto;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            text-transform: uppercase; 
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        
        /* Garis putus-putus ala struk */
        .garis-putus {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .garis-tebal {
            border-top: 2px dashed #000;
            margin: 10px 0;
        }
        
        /* Pengaturan tabel agar padat dan rapi */
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; padding: 2px 0; }
        
        /* Tombol Aksi */
        .btn-area { text-align: center; margin-top: 20px; }
        .btn { 
            padding: 10px 15px; 
            margin: 5px; 
            cursor: pointer; 
            font-family: Arial, sans-serif;
            font-weight: bold;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-kembali { background-color: #6c757d; }
        
        /* Mode Print: Sembunyikan tombol dan bayangan kertas saat dicetak betulan */
        @media print {
            body { background-color: #fff; margin: 0; }
            .struk-container { width: 100%; max-width: 300px; box-shadow: none; margin: 0; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="struk-container">
        <!-- Header Struk -->
        <div class="text-center">
            <h3 style="margin: 0; font-size: 14px;">PAMSIMAS KORONG PADANG LARIANG BARAT</h3>
            <p style="margin: 5px 0;">PENGELOLAAN AIR BERSIH</p>
            <p style="margin: 0; font-size: 10px;">NAGARI IV KOTO AUA MALINTANG</p>
        </div>
        
        <div class="garis-putus"></div>
        
        <!-- Info Transaksi & Warga -->
        <table>
            <tr>
                <td width="70">NO. INV</td>
                <td width="10">:</td>
                <td>INV-{{ str_pad($tagihan->id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td>TANGGAL</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>NAMA</td>
                <td>:</td>
                <td>{{ $tagihan->pelanggan->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>NO. PLG</td>
                <td>:</td>
                <td>{{ $tagihan->pelanggan->no_pelanggan ?? '-' }}</td>
            </tr>
            <tr>
                <td>STATUS</td>
                <td>:</td>
                <td class="bold">
                    @if(strtolower($tagihan->status) == 'lunas')
                        LUNAS
                    @else
                        BELUM LUNAS
                    @endif
                </td>
            </tr>
        </table>
        
        <div class="garis-putus"></div>
        
        <!-- Detail Pemakaian Air -->
        <table>
            <tr>
                <td colspan="3" class="bold">AIR BLN: {{ substr($tagihan->bulan ?? '-', 0, 3) }} {{ $tagihan->tahun ?? '-' }}</td>
            </tr>
            <tr>
                <td>PEMAKAIAN</td>
                <td class="text-right">{{ $tagihan->jumlah_meter ?? $tagihan->pemakaian ?? 0 }} M³</td>
                <td class="text-right">RP {{ number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>
        
        <div class="garis-tebal"></div>
        
        <!-- Total Harga -->
        <table>
            <tr class="bold" style="font-size: 14px;">
                <td>TOTAL</td>
                <td class="text-right">RP {{ number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>
        
        <div class="garis-putus"></div>
        
        <!-- Footer Pesan -->
        <div class="text-center" style="font-size: 10px;">
            <p style="margin: 5px 0;">TERIMA KASIH ATAS PEMBAYARAN ANDA</p>
            <p style="margin: 0;">"GUNAKAN AIR DENGAN BIJAK"</p>
        </div>
    </div>

    <!-- Tombol Navigasi (Hanya muncul di layar komputer) -->
    <div class="btn-area no-print">
        <button class="btn" onclick="window.print()">Cetak Ulang</button>
        <a href="{{ route('admin.tagihan.index') }}" class="btn btn-kembali">Kembali</a>
    </div>

</body>
</html>