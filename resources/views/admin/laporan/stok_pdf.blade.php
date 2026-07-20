<!DOCTYPE html>
<html>
<head>
    <title>Laporan Audit Stok</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #111; }
        .kop-table { width: 100%; background: #312e81; color: #fff; border-radius: 12px; margin-bottom: 25px; border-collapse: collapse; }
        .kop-table td { padding: 15px 20px; vertical-align: middle; }
        .kop-logo { height: 45px; background: #fff; padding: 5px; border-radius: 8px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th { background: #f3f4f6; padding: 12px; border: 1px solid #ddd; text-align: left; text-transform: uppercase; font-size: 10px; }
        table.data td { padding: 12px; border: 1px solid #ddd; }
        .stok-aman { color: #059669; font-weight: bold; }
        .stok-kritis { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>
    <table class="kop-table">
        <tr>
            <td style="width: 60px;"><img src="{{ public_path('images/orbit.png') }}" class="kop-logo"></td>
            <td>
                <h2 style="margin:0; text-transform: uppercase;">ORBIT DIGITAL PRINTING</h2>
                <p style="margin:5px 0 0;">Laporan Audit & Kontrol Stok Bahan Baku</p>
            </td>
            <td style="text-align: right; font-size: 10px;">Dicetak: {{ date('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>Nama Bahan Baku</th>
                <th>Sisa Stok Saat Ini</th>
                <th>Batas Minimum</th>
                <th>Satuan</th>
                <th>Status Audit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bahan as $b)
            <tr>
                <td style="font-weight: bold;">{{ $b->nama_bahan }}</td>
                <td>{{ $b->stok }}</td>
                <td>{{ $b->minimum_stok }}</td>
                <td>{{ $b->satuan }}</td>
                <td class="{{ $b->stok <= $b->minimum_stok ? 'stok-kritis' : 'stok-aman' }}">
                    {{ $b->stok <= $b->minimum_stok ? 'KRITIS - Perlu Restock (Min: '.$b->minimum_stok.')' : 'AMAN' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>