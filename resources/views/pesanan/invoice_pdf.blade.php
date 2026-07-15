<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $pesanan->nomor_invoice }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: right; border-bottom: 2px solid #4f46e5; padding-bottom: 20px; }
        .header h1 { color: #4f46e5; margin: 0; font-size: 28px; }
        .info { margin-top: 30px; width: 100%; }
        .info td { vertical-align: top; font-size: 13px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 40px; }
        .table th { background: #f9fafb; padding: 12px; border-bottom: 1px solid #edf2f7; text-align: left; font-size: 11px; text-transform: uppercase; color: #718096; }
        .table td { padding: 15px 12px; border-bottom: 1px solid #edf2f7; font-size: 12px; }
        .total-box { margin-top: 40px; float: right; width: 300px; background: #f9fafb; padding: 20px; border-radius: 15px; }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 13px; }
        .grand-total { font-size: 20px; font-weight: bold; color: #4f46e5; margin-top: 10px; border-top: 1px solid #e2e8f0; padding-top: 10px; }
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 10px; text-align: center; color: #a0aec0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ORBIT PRINT</h1>
        <p style="margin: 5px 0;">Solusi Cetak Digital Berkualitas</p>
        <p style="font-size: 12px; color: #718096;">Banjarmasin, Kalimantan Selatan</p>
    </div>

    <table class="info">
        <tr>
            <td style="width: 50%;">
                <strong style="text-transform: uppercase; color: #718096; font-size: 10px;">Ditujukan Kepada:</strong><br>
                <span style="font-size: 16px; font-weight: bold;">{{ $pesanan->user->name }}</span><br>
                {{ $pesanan->user->telepon }}<br>
                {{ $pesanan->user->alamat }}
            </td>
            <td style="text-align: right;">
                <strong style="text-transform: uppercase; color: #718096; font-size: 10px;">Nomor Invoice:</strong><br>
                <span style="font-size: 14px; font-weight: bold;">{{ $pesanan->nomor_invoice }}</span><br><br>
                <strong style="text-transform: uppercase; color: #718096; font-size: 10px;">Tanggal:</strong><br>
                {{ $pesanan->created_at->format('d F Y') }}
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Item Produk</th>
                <th style="text-align: center;">Ukuran</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->detailPesanan as $detail)
            <tr>
                <td>
                    <strong>{{ $detail->produk->nama_produk }}</strong><br>
                    <small style="color: #718096;">Finishing: {{ $detail->finishing ?? '-' }}</small>
                </td>
                <td style="text-align: center;">{{ $detail->panjang }}{{ $detail->produk->satuan ?? 'm' }} x {{ $detail->lebar }}{{ $detail->produk->satuan ?? 'm' }}</td>
                <td style="text-align: center;">{{ $detail->jumlah }}</td>
                <td style="text-align: right;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <div style="margin-bottom: 5px;">
            <span style="color: #718096;">Subtotal:</span>
            <span style="float: right;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
        </div>
        @if($pesanan->potongan_diskon > 0)
        <div style="margin-bottom: 5px; color: #059669;">
            <span>Diskon Grosir (10%):</span>
            <span style="float: right;">- Rp {{ number_format($pesanan->potongan_diskon, 0, ',', '.') }}</span>
        </div>
        @endif
        @if($pesanan->ongkir > 0)
        <div style="margin-bottom: 5px; color: #c2410c;">
            <span>Ongkos Kirim:</span>
            <span style="float: right;">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
        </div>
        @endif
        <div class="grand-total">
            <span>Total Bayar:</span>
            <span style="float: right;">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
        </div>
        <p style="margin-top: 15px; font-size: 10px; color: #718096; text-align: center; border: 1px dashed #cbd5e0; padding: 5px;">
            Status Pembayaran: <strong>LUNAS</strong>
        </p>
    </div>

    <div class="footer">
        Nota ini dihasilkan otomatis oleh sistem Orbit Print. Terima kasih atas kepercayaan Anda.
    </div>
</body>
</html>