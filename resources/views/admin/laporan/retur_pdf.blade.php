<!DOCTYPE html>
<html>
<head>
    <title>Monitoring Pesanan</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #111; margin: 0; padding: 20px; }
        .kop-table { width: 100%; background: #1e1b4b; color: #fff; border-radius: 12px; margin-bottom: 25px; border-collapse: collapse; }
        .kop-table td { padding: 15px 20px; vertical-align: middle; }
        .kop-logo { height: 45px; background: #fff; padding: 5px; border-radius: 8px; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        table.data th { background: #f3f4f6; color: #374151; padding: 10px 12px; border: 1px solid #ddd; text-align: left; text-transform: uppercase; font-size: 10px; }
        table.data td { padding: 10px 12px; border: 1px solid #ddd; }
        .stat-box { display: inline-block; text-align: center; padding: 15px 20px; border-radius: 10px; margin-right: 12px; }
        .stat-indigo { background: #eef2ff; border: 1px solid #c7d2fe; }
        .stat-emerald { background: #ecfdf5; border: 1px solid #a7f3d0; }
        .stat-amber { background: #fffbeb; border: 1px solid #fde68a; }
        .stat-label { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; color: #888; margin-bottom: 5px; }
        .stat-value { font-size: 22px; font-weight: 900; }
        .stat-indigo .stat-value { color: #4338ca; }
        .stat-emerald .stat-value { color: #059669; }
        .stat-amber .stat-value { color: #d97706; }
        .section-title { font-size: 13px; font-weight: 900; text-transform: uppercase; color: #1e1b4b; border-bottom: 2px solid #c7d2fe; padding-bottom: 5px; margin: 25px 0 15px 0; letter-spacing: 0.5px; }
        .status-badge { display: inline-block; padding: 2px 8px; border-radius: 6px; font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
</head>
<body>
    <table class="kop-table">
        <tr>
            <td style="width: 60px;"><img src="{{ public_path('images/orbit.png') }}" class="kop-logo"></td>
            <td>
                <h2 style="margin:0; text-transform: uppercase;">ORBIT DIGITAL PRINTING</h2>
                <p style="margin:5px 0 0;">Monitoring Pesanan</p>
            </td>
            <td style="text-align: right; font-size: 10px;">Periode: {{ date('Y') }}<br>Dicetak: {{ date('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <div style="margin-bottom: 20px;">
        <div class="stat-box stat-indigo">
            <div class="stat-label">Total Semua Order</div>
            <div class="stat-value">{{ $totalOrder }}</div>
        </div>
        <div class="stat-box stat-emerald">
            <div class="stat-label">Total Omzet Selesai</div>
            <div class="stat-value">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
        </div>
        <div class="stat-box stat-amber">
            <div class="stat-label">Sedang Diproses</div>
            <div class="stat-value">{{ $orderAktif }}</div>
        </div>
    </div>

    <div class="section-title">Status Pesanan Saat Ini</div>
    <table class="data">
        <thead>
            <tr>
                <th>Status</th>
                <th style="text-align: right;">Jumlah Order</th>
                <th style="text-align: right;">Total Nilai</th>
                <th style="text-align: right;">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php($statusColors = [
                'Verifikasi' => ['#fef3c7', '#92400e'],
                'Antrean Cetak' => ['#dbeafe', '#1e40af'],
                'Produksi' => ['#ede9fe', '#5b21b6'],
                'Siap Ambil' => ['#d1fae5', '#065f46'],
                'Sedang Dikirim' => ['#e0e7ff', '#3730a3'],
                'Selesai' => ['#ecfdf5', '#047857'],
                'Dibatalkan' => ['#fee2e2', '#991b1b'],
            ])
            @foreach($perStatus as $status => $data)
            @php($colors = $statusColors[$status] ?? ['#f3f4f6', '#374151'])
            <tr>
                <td>
                    <span class="status-badge" style="background: {{ $colors[0] }}; color: {{ $colors[1] }};">{{ $status }}</span>
                </td>
                <td style="text-align: right; font-weight: bold;">{{ $data['jumlah'] }}</td>
                <td style="text-align: right;">Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
                <td style="text-align: right;">{{ $totalOrder > 0 ? round(($data['jumlah'] / $totalOrder) * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Tren Pesanan 6 Bulan Terakhir</div>
    <table class="data">
        <thead>
            <tr>
                <th>Bulan</th>
                <th style="text-align: right;">Jumlah Order</th>
                <th style="text-align: right;">Total Nilai</th>
                <th style="text-align: right;">Rata-rata / Order</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perBulan as $bulan)
            <tr>
                <td style="font-weight: bold;">{{ $bulan['label'] }}</td>
                <td style="text-align: right;">{{ $bulan['jumlah'] }}</td>
                <td style="text-align: right;">Rp {{ number_format($bulan['total'], 0, ',', '.') }}</td>
                <td style="text-align: right;">{{ $bulan['jumlah'] > 0 ? 'Rp ' . number_format($bulan['total'] / $bulan['jumlah'], 0, ',', '.') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 15px; color: #999;">Belum ada data pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">10 Pesanan Terbaru</div>
    <table class="data">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th style="text-align: right;">Total Bayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesananTerbaru as $p)
            @php($sc = $statusColors[$p->status] ?? ['#f3f4f6', '#374151'])
            <tr>
                <td style="font-weight: bold;">{{ $p->nomor_invoice }}</td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                <td>{{ $p->user->name }}</td>
                <td style="text-align: right;">Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                <td>
                    <span class="status-badge" style="background: {{ $sc[0] }}; color: {{ $sc[1] }};">{{ $p->status }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 15px; color: #999;">Belum ada pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
