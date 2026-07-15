<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produk Terlaris</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #111; }
        .kop-table { width: 100%; background: #312e81; color: #fff; border-radius: 10px; margin-bottom: 25px; border-collapse: collapse; }
        .kop-table td { padding: 20px; border: none; vertical-align: middle; }
        .kop-logo { height: 45px; width: auto; background: #fff; padding: 5px; border-radius: 8px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th { background: #f3f4f6; padding: 12px; border: 1px solid #ddd; text-align: left; text-transform: uppercase; font-weight: bold; }
        table.data td { padding: 12px; border: 1px solid #ddd; }
        .rank { font-weight: bold; color: #312e81; text-align: center; width: 40px; }
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
                <p style="margin:5px 0 0; font-weight: bold;">Laporan Analisis Produk Terlaris</p>
            </td>
            <td style="text-align: right; font-size: 10px;">
                Dicetak: {{ date('d F Y, H:i') }} WITA
            </td>
        </tr>
    </table>

    <h3 style="text-align: center; text-transform: uppercase; border-bottom: 2px solid #312e81; padding-bottom: 5px;">Peringkat Produk Berdasarkan Penjualan</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th>Nama Produk</th>
                <th style="text-align: center;">Total Kuantitas Cetak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produkTerlaris as $index => $p)
            <tr>
                <td class="rank">{{ $index + 1 }}</td>
                <td style="font-weight: bold;">{{ $p->nama_produk }}</td>
                <td style="text-align: center;">{{ number_format($p->total_qty, 0, ',', '.') }} Pcs</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>