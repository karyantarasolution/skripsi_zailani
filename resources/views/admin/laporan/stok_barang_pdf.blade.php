<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Barang</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #111; }
        .kop-table { width: 100%; background: #312e81; color: #fff; border-radius: 12px; margin-bottom: 25px; border-collapse: collapse; }
        .kop-table td { padding: 15px 20px; vertical-align: middle; }
        .kop-logo { height: 45px; background: #fff; padding: 5px; border-radius: 8px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th { background: #f3f4f6; padding: 12px; border: 1px solid #ddd; text-align: left; text-transform: uppercase; font-size: 10px; }
        table.data td { padding: 12px; border: 1px solid #ddd; }
        .bahan-list { font-size: 10px; color: #6b7280; margin-top: 4px; }
    </style>
</head>
<body>
    <table class="kop-table">
        <tr>
            <td style="width: 60px;"><img src="{{ public_path('images/orbit.png') }}" class="kop-logo"></td>
            <td>
                <h2 style="margin:0; text-transform: uppercase;">ORBIT DIGITAL PRINTING</h2>
                <p style="margin:5px 0 0;">Laporan Stok Barang / Produk</p>
            </td>
            <td style="text-align: right; font-size: 10px;">Dicetak: {{ date('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang / Produk</th>
                <th>Harga Dasar</th>
                <th>Satuan</th>
                <th>Bahan Baku Terkait</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produk as $idx => $p)
            <tr>
                <td style="text-align: center; font-weight: bold;">{{ $idx + 1 }}</td>
                <td style="font-weight: bold;">{{ $p->nama_produk }}</td>
                <td>Rp {{ number_format($p->harga_dasar, 0, ',', '.') }}</td>
                <td>{{ strtoupper($p->satuan) }}</td>
                <td>
                    @if($p->bahanBaku->count() > 0)
                        @foreach($p->bahanBaku as $b)
                            <span class="bahan-list">{{ $b->nama_bahan }} ({{ $b->stok }} {{ $b->satuan }})@if(!$loop->last), @endif</span>
                        @endforeach
                    @else
                        <span class="bahan-list">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; color: #9ca3af;">Belum ada data barang / produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
