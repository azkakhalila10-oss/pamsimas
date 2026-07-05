<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran PAMSIMAS - {{ $tagihan->pelanggan->no_pelanggan }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            color: #000;
            background-color: #fff;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 1.4rem;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 0.8rem;
        }
        .meta-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-data td {
            padding: 6px 0;
            font-size: 0.9rem;
        }
        .table-data td.label {
            width: 45%;
        }
        .table-data td.value {
            text-align: right;
        }
        .total-box {
            border-top: 1px dashed #000;
            border-bottom: 2px dashed #000;
            padding: 10px 0;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .footer {
            text-align: center;
            font-size: 0.8rem;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            margin-bottom: 50px;
            font-size: 0.9rem;
        }
        .signature-box {
            text-align: center;
            width: 40%;
        }
        .signature-space {
            height: 60px;
        }

        /* Otomatis memicu pop-up print browser saat halaman dimuat */
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <!-- Tombol Bantu Cetak (Akan sembunyi otomatis saat diprint) -->
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 6px 12px; font-weight: bold; cursor: pointer;">🖨 Cetak Dokumen</button>
        <button onclick="window.close()" style="padding: 6px 12px; cursor: pointer;">✕ Tutup</button>
    </div>

    <!-- KOP NOTA RESMI -->
    <div class="header">
        <h2>PAMSIMAS TIRTA BERSIH</h2>
        <p>KORONG PADANG LARIANG BARAT</p>
        <p>Layanan Air Bersih Masyarakat Desa Terpercaya</p>
    </div>

    <!-- INFO NOTA -->
    <div class="meta-info">
        <div>
            <strong>No. Nota:</strong> INV/{{ $tagihan->id }}/{{ $tagihan->tahun }}/{{ strtoupper(substr($tagihan->bulan, 0, 3)) }}<br>
            <strong>Warga:</strong> {{ $tagihan->pelanggan->nama }}
        </div>
        <div style="text-align: right;">
            <strong>Tanggal Lunas:</strong> {{ date('d/m/Y') }}<br>
            <strong>ID Pelanggan:</strong> {{ $tagihan->pelanggan->no_pelanggan }}
        </div>
    </div>

    <!-- RINCIAN PENGGUNAAN AIR & BIAYA -->
    <table class="table-data">
        <tr>
            <td class="label">Periode Pemakaian</td>
            <td class="value text-uppercase">{{ ucfirst($tagihan->bulan) }} {{ $tagihan->tahun }}</td>
        </tr>
        <tr>
            <td class="label">Meteran Bulan Lalu</td>
            <td class="value">{{ $tagihan->meteran_lalu }} M³</td>
        </tr>
        <tr>
            <td class="label">Meteran Bulan Ini</td>
            <td class="value">{{ $tagihan->meteran_baru }} M³</td>
        </tr>
        <tr>
            <td class="label">Total Pemakaian Kubikasi</td>
            <td class="value" style="font-weight: bold;">{{ $tagihan->total_kubik }} M³</td>
        </tr>
        <tr>
            <td class="label">Tarif per M³ (Rp 3.000)</td>
            <td class="value">Rp {{ number_format($tagihan->total_kubik * 3000, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Biaya Beban Perawatan (Abone)</td>
            <td class="value">Rp 10.000</td>
        </tr>
    </table>

    <!-- TOTAL AKHIR -->
    <div class="total-box">
        <span>TOTAL PEMBAYARAN:</span>
        <span>Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</span>
    </div>

    <!-- AREA TANDA TANGAN -->
    <div class="signature-section">
        <div class="signature-box">
            <span>Pelanggan / Warga</span>
            <div class="signature-space"></div>
            <strong>( {{ $tagihan->pelanggan->nama }} )</strong>
        </div>
        <div class="signature-box">
            <span>Bendahara PAMSIMAS</span>
            <div class="signature-space"></div>
            <strong>( Lailatul Zikri )</strong>
        </div>
    </div>

    <!-- KATA PENUTUP -->
    <div class="footer">
        <p style="font-style: italic;">"Terima kasih telah membayar iuran tepat waktu.<br>Air bersih untuk kehidupan desa yang lebih sehat!"</p>
        <p style="margin-top: 15px; border-top: 1px dotted #000; padding-top: 5px; font-size: 0.75rem;">Struk ini merupakan bukti pembayaran yang sah.</p>
    </div>

    <!-- Script memicu cetak otomatis saat halaman terbuka -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>