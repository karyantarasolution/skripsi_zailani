<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemakaian Bahan</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #111; }
        .kop-table { width: 100%; background: #312e81; color: #fff; border-radius: 12px; margin-bottom: 25px; border-collapse: collapse; }
        .kop-table td { padding: 15px 20px; border: none; vertical-align: middle; }
        .kop-logo { height: 45px; width: auto; background: #fff; padding: 5px; border-radius: 8px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th { background: #f3f4f6; padding: 12px; border: 1px solid #ddd; text-align: left; text-transform: uppercase; font-size: 10px; }
        table.data td { padding: 12px; border: 1px solid #ddd; }
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
                <p style="margin:5px 0 0; font-weight: bold;">Laporan Rekapitulasi Pemakaian Bahan Baku</p>
            </td>
            <td style="text-align: right; font-size: 10px;">
                Dicetak: {{ date('d/m/Y H:i') }} WITA
            </td>
        </tr>
    </table>

    <p style="font-size: 10px; color: #666; margin-bottom: 15px; font-style: italic;">
        *Laporan ini menampilkan total pemakaian bahan baku dari semua pesanan yang sedang/telah diproduksi.
    </p>

    <table class="data">
        <thead>
            <tr>
                <th>Nama Bahan Baku</th>
                <th>Total Terpakai</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapBahan as $b)
            <tr>
                <td style="font-weight: bold;">{{ $b->nama_bahan }}</td>
                <td>{{ number_format($b->total_pemakaian, 2) }}</td>
                <td>{{ $b->satuan ?? 'm²' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; padding: 20px; color: #999;">
                    Belum ada data pemakaian bahan. Pastikan ada pesanan yang sudah diproduksi/selesai.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
