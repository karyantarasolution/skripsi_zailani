<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembatalan Pesanan</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .kop-table { width: 100%; background: #b91c1c; color: #fff; border-radius: 10px; margin-bottom: 25px; border-collapse: collapse; }
        .kop-table td { padding: 20px; border: none; vertical-align: middle; }
        .kop-logo { height: 45px; width: auto; background: #fff; padding: 5px; border-radius: 8px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th { background: #fee2e2; color: #991b1b; padding: 10px; border: 1px solid #ddd; text-align: left; }
        table.data td { padding: 10px; border: 1px solid #ddd; }
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
                <p style="margin:5px 0 0; font-weight: bold;">Laporan Log Pembatalan & Retur Pesanan</p>
            </td>
            <td style="text-align: right; font-size: 10px;">
                Filter: Semua Pembatalan<br>
                Dicetak: {{ date('d/m/Y H:i') }} WITA
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Tanggal Order</th>
                <th>Pelanggan</th>
                <th>Total Transaksi</th>
                <th>Alasan / Status Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembatalan as $p)
            <tr>
                <td style="font-weight: bold;">{{ $p->nomor_invoice }}</td>
                <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $p->user->name }}</td>
                <td>Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                <td style="color: #b91c1c; font-style: italic;">Dibatalkan (Verifikasi Gagal / Ditolak Admin)</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">Tidak ada riwayat pembatalan pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>