<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Orbit Digital</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #111; }
        .kop-table { width: 100%; background: #312e81; color: #fff; border-radius: 12px; margin-bottom: 25px; border-collapse: collapse; }
        .kop-table td { padding: 15px 20px; border: none; vertical-align: middle; }
        .kop-logo { height: 45px; width: auto; background: #fff; padding: 5px; border-radius: 8px; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background: #4f46e5; color: white; padding: 8px; border: 1px solid #ddd; text-transform: uppercase; font-size: 10px; }
        table.data td { padding: 8px; border: 1px solid #ddd; }
        .total-box { text-align: right; font-size: 14px; font-weight: bold; background: #f3f4f6; padding: 10px; border-radius: 8px; margin-top: 15px; }
        .footer { margin-top: 50px; text-align: right; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <table class="kop-table">
        <tr>
            <td style="width: 60px;">
                <img src="{{ public_path('images/orbit.png') }}" alt="Logo" class="kop-logo">
            </td>
            <td>
                <h2 style="margin:0; text-transform: uppercase; letter-spacing: 1px;">ORBIT DIGITAL PRINTING</h2>
                <p style="margin:5px 0 0; font-weight: bold;">Laporan Penjualan Bulanan (Selesai)</p>
            </td>
            <td style="text-align: right; font-size: 10px;">
                Periode: {{ date('F Y') }}<br>
                Dicetak: {{ date('d/m/Y H:i') }} WITA
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th>Tgl</th>
                <th>Invoice</th>
                <th>Pelanggan</th>
                <th>Metode</th>
                <th style="text-align: right;">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan as $index => $p)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                <td style="font-weight: bold;">{{ $p->nomor_invoice }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ explode(' | ', $p->metode_pengiriman)[0] }}</td>
                <td style="text-align: right;">Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        TOTAL OMZET BULAN INI: Rp {{ number_format($totalOmzet, 0, ',', '.') }}
    </div>

    <div class="footer">
        <p>Banjarmasin, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><strong>( Admin Utama )</strong></p>
    </div>
</body>
</html>
