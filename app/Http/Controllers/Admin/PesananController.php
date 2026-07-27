<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\BahanBaku;
use App\Models\User;
use App\Models\RiwayatStok;
use App\Models\RiwayatPesanan;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with('user')
            ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->latest()
            ->get();
        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function selesai()
    {
        $pesanan = Pesanan::with('user')
            ->whereIn('status', ['Selesai', 'Dibatalkan'])
            ->latest()
            ->get();
        return view('admin.pesanan.selesai', compact('pesanan'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.produk'])->findOrFail($id);
        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::with('detailPesanan.produk.bahanBaku')->findOrFail($id);
        $statusLama = $pesanan->status;
        $statusBaru = $request->status;

        if ($request->has('ongkir')) {
            $ongkirBaru = (int) $request->ongkir;
            $totalBayarBaru = $pesanan->total_harga - $pesanan->potongan_diskon + $ongkirBaru;
            $pesanan->update(['ongkir' => $ongkirBaru, 'total_bayar' => $totalBayarBaru]);
        }

        if (($statusBaru == 'Produksi' || $statusBaru == 'Selesai') && ($statusLama != 'Produksi' && $statusLama != 'Selesai')) {
            foreach ($pesanan->detailPesanan as $item) {
                $pembagi = match($item->produk->satuan) {
                    'mm' => 1000,
                    'cm' => 100,
                    default => 1,
                };
                $luasM2 = ($item->panjang / $pembagi) * ($item->lebar / $pembagi);
                foreach ($item->produk->bahanBaku as $bahan) {
                    $penggunaan = ($bahan->pivot->tipe_pengurangan == 'per_meter') 
                                  ? ($luasM2 * $bahan->pivot->jumlah_digunakan * $item->jumlah) 
                                  : ($bahan->pivot->jumlah_digunakan * $item->jumlah);

                    $stok_sebelum = $bahan->stok;
                    $stok_sesudah = $stok_sebelum - $penggunaan;

                    $bahan->update(['stok' => $stok_sesudah]);

                    RiwayatStok::create([
                        'bahan_baku_id' => $bahan->id,
                        'user_id' => auth()->id(),
                        'jenis' => 'keluar',
                        'jumlah' => $penggunaan,
                        'stok_sebelum' => $stok_sebelum,
                        'stok_sesudah' => $stok_sesudah,
                        'keterangan' => "Potong Stok Otomatis: " . $pesanan->nomor_invoice
                    ]);
                }
            }
        }

        if ($statusBaru == 'Dibatalkan' && ($statusLama == 'Produksi' || $statusLama == 'Selesai')) {
            foreach ($pesanan->detailPesanan as $item) {
                $pembagi = match($item->produk->satuan) {
                    'mm' => 1000,
                    'cm' => 100,
                    default => 1,
                };
                $luasM2 = ($item->panjang / $pembagi) * ($item->lebar / $pembagi);
                foreach ($item->produk->bahanBaku as $bahan) {
                    $penggunaan = ($bahan->pivot->tipe_pengurangan == 'per_meter') 
                                  ? ($luasM2 * $bahan->pivot->jumlah_digunakan * $item->jumlah) 
                                  : ($bahan->pivot->jumlah_digunakan * $item->jumlah);

                    $stok_sebelum = $bahan->stok;
                    $stok_sesudah = $stok_sebelum + $penggunaan;

                    $bahan->update(['stok' => $stok_sesudah]);

                    RiwayatStok::create([
                        'bahan_baku_id' => $bahan->id,
                        'user_id' => auth()->id(),
                        'jenis' => 'masuk',
                        'jumlah' => $penggunaan,
                        'stok_sebelum' => $stok_sebelum,
                        'stok_sesudah' => $stok_sesudah,
                        'keterangan' => "Pembatalan: " . $pesanan->nomor_invoice
                    ]);
                }
            }
        }

        $pesanan->update(['status' => $statusBaru]);

        RiwayatPesanan::create([
            'pesanan_id' => $pesanan->id,
            'status_log' => $statusBaru,
            'catatan' => $request->catatan ?? 'Status diubah oleh ' . auth()->user()->name,
        ]);

        try {
            $fonnte = new FonnteService();
            $customer = $pesanan->user;

            if (!empty($customer->telepon)) {
                $statusLabels = [
                    'Verifikasi' => '✅ Pembayaran sedang diverifikasi',
                    'Antrean Cetak' => '📋 Pesanan masuk antrean cetak',
                    'Produksi' => '🔧 Pesanan sedang diproduksi',
                    'Siap Ambil' => '📦 Pesanan siap diambil di toko',
                    'Sedang Dikirim' => '🚚 Paket sedang dalam perjalanan',
                    'Selesai' => '🎉 Pesanan selesai! Terima kasih',
                    'Dibatalkan' => '❌ Pesanan dibatalkan',
                ];

                $label = $statusLabels[$statusBaru] ?? $statusBaru;

                $message = "*UPDATE STATUS PESANAN* 🖨️\n\n"
                    . "Halo " . $customer->name . ",\n\n"
                    . "Pesanan *" . $pesanan->nomor_invoice . "* status Anda:\n"
                    . "➡️ " . $label . "\n\n";

                if ($statusBaru == 'Selesai') {
                    $message .= "Jangan lupa beri ulasan ya! 🙏\n";
                } elseif ($statusBaru == 'Dibatalkan') {
                    $message .= "Jika ada pertanyaan, silakan hubungi kami.\n";
                } else {
                    $message .= "Terima kasih telah berbelanja di Orbit Digital Printing 🙏\n";
                }

                $message .= "\n" . url('/riwayat-pesanan/' . $pesanan->id);

                $fonnte->sendMessage($customer->telepon, $message);
            }
        } catch (\Exception $e) {
            Log::error('Gagal kirim WA notif ke pelanggan: ' . $e->getMessage());
        }

        return back()->with('success', 'Status diperbarui & Stok bahan telah disesuaikan otomatis!');
    }

    public function cetakLabel($id)
    {
        $pesanan = Pesanan::with('user')->findOrFail($id);
        $resi = 'REG-' . strtoupper(substr($pesanan->nomor_invoice, -5));

        $pdf = Pdf::loadView('admin.pesanan.pdf_label', compact('pesanan', 'resi'))
                  ->setPaper([0, 0, 283, 420], 'portrait');
                  
        return $pdf->stream('Label-' . $pesanan->nomor_invoice . '.pdf');
    }

    public function cetakSPK($id)
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.produk'])->findOrFail($id);
        
        $pdf = Pdf::loadView('admin.pesanan.pdf_spk', compact('pesanan'))
                  ->setPaper('a4', 'portrait');
                  
        return $pdf->stream('SPK-' . $pesanan->nomor_invoice . '.pdf');
    }

    // ===== WEB VIEW LAPORAN =====
    public function laporanPenjualan()
    {
        $pesanan = Pesanan::with('user')
                    ->where('status', 'Selesai')
                    ->whereMonth('created_at', date('m'))
                    ->latest()
                    ->get();
        $totalOmzet = $pesanan->sum('total_bayar');
        return view('admin.laporan.penjualan_web', compact('pesanan', 'totalOmzet'));
    }

    public function laporanPenjualanPdf()
    {
        $pesanan = Pesanan::with('user')
                    ->where('status', 'Selesai')
                    ->whereMonth('created_at', date('m'))
                    ->latest()
                    ->get();
        $totalOmzet = $pesanan->sum('total_bayar');
        $pdf = Pdf::loadView('admin.laporan.penjualan_pdf', compact('pesanan', 'totalOmzet'))
                  ->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Penjualan-'.date('M-Y').'.pdf');
    }

    public function laporanBahan()
    {
        $cekJumlah = \App\Models\BahanBaku::count();
        $cekFormula = DB::table('produk_bahan')->count();
        if ($cekJumlah == 0) {
            return redirect()->route('admin.dashboard')->with('error', 'Tidak ada data bahan baku!');
        }
        if ($cekFormula == 0) {
            return redirect()->route('admin.dashboard')->with('error', 'Formula bahan baku belum diatur!');
        }
        $rekapBahan = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->join('produk', 'detail_pesanan.produk_id', '=', 'produk.id')
            ->join('produk_bahan', 'produk.id', '=', 'produk_bahan.produk_id')
            ->join('bahan_baku', 'produk_bahan.bahan_baku_id', '=', 'bahan_baku.id')
            ->whereIn('pesanan.status', ['Produksi', 'Siap Ambil', 'Sedang Dikirim', 'Selesai'])
            ->selectRaw('bahan_baku.nama_bahan, bahan_baku.satuan,
                SUM(CASE 
                    WHEN produk_bahan.tipe_pengurangan = "per_meter" 
                    THEN (
                        (CASE 
                            WHEN produk.satuan = "cm" THEN detail_pesanan.panjang / 100.0
                            WHEN produk.satuan = "mm" THEN detail_pesanan.panjang / 1000.0
                            ELSE detail_pesanan.panjang
                        END) *
                        (CASE 
                            WHEN produk.satuan = "cm" THEN detail_pesanan.lebar / 100.0
                            WHEN produk.satuan = "mm" THEN detail_pesanan.lebar / 1000.0
                            ELSE detail_pesanan.lebar
                        END) *
                        produk_bahan.jumlah_digunakan * detail_pesanan.jumlah
                    )
                    ELSE (produk_bahan.jumlah_digunakan * detail_pesanan.jumlah)
                END) as total_pemakaian')
            ->groupBy('bahan_baku.nama_bahan', 'bahan_baku.satuan')
            ->get();
        return view('admin.laporan.bahan_web', compact('rekapBahan'));
    }

    public function laporanBahanPdf()
    {
        $rekapBahan = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->join('produk', 'detail_pesanan.produk_id', '=', 'produk.id')
            ->join('produk_bahan', 'produk.id', '=', 'produk_bahan.produk_id')
            ->join('bahan_baku', 'produk_bahan.bahan_baku_id', '=', 'bahan_baku.id')
            ->whereIn('pesanan.status', ['Produksi', 'Siap Ambil', 'Sedang Dikirim', 'Selesai'])
            ->selectRaw('bahan_baku.nama_bahan, bahan_baku.satuan,
                SUM(CASE 
                    WHEN produk_bahan.tipe_pengurangan = "per_meter" 
                    THEN (
                        (CASE WHEN produk.satuan = "cm" THEN detail_pesanan.panjang / 100.0 WHEN produk.satuan = "mm" THEN detail_pesanan.panjang / 1000.0 ELSE detail_pesanan.panjang END) *
                        (CASE WHEN produk.satuan = "cm" THEN detail_pesanan.lebar / 100.0 WHEN produk.satuan = "mm" THEN detail_pesanan.lebar / 1000.0 ELSE detail_pesanan.lebar END) *
                        produk_bahan.jumlah_digunakan * detail_pesanan.jumlah
                    )
                    ELSE (produk_bahan.jumlah_digunakan * detail_pesanan.jumlah)
                END) as total_pemakaian')
            ->groupBy('bahan_baku.nama_bahan', 'bahan_baku.satuan')
            ->get();
        $pdf = Pdf::loadView('admin.laporan.bahan_pdf', compact('rekapBahan'))->setPaper('a4', 'portrait');
        return $pdf->stream('Laporan-Pemakaian-Bahan.pdf');
    }

    public function laporanTerlaris()
    {
        $produkTerlaris = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->join('produk', 'detail_pesanan.produk_id', '=', 'produk.id')
            ->where('pesanan.status', 'Selesai')
            ->selectRaw('produk.nama_produk, SUM(detail_pesanan.jumlah) as total_qty')
            ->groupBy('produk.nama_produk')
            ->orderBy('total_qty', 'DESC')
            ->get();
        return view('admin.laporan.terlaris_web', compact('produkTerlaris'));
    }

    public function laporanTerlarisPdf()
    {
        $produkTerlaris = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->join('produk', 'detail_pesanan.produk_id', '=', 'produk.id')
            ->where('pesanan.status', 'Selesai')
            ->selectRaw('produk.nama_produk, SUM(detail_pesanan.jumlah) as total_qty')
            ->groupBy('produk.nama_produk')
            ->orderBy('total_qty', 'DESC')
            ->get();
        $pdf = Pdf::loadView('admin.laporan.terlaris_pdf', compact('produkTerlaris'));
        return $pdf->stream('Laporan-Produk-Terlaris.pdf');
    }

    public function laporanTopPelanggan()
    {
        $topUsers = User::where('role', 'pelanggan')
            ->withCount(['pesanan' => function($q) { $q->where('status', 'Selesai'); }])
            ->withSum(['pesanan' => function($q) { $q->where('status', 'Selesai'); }], 'total_bayar')
            ->having('pesanan_count', '>', 0)
            ->orderBy('pesanan_sum_total_bayar', 'DESC')
            ->take(10)
            ->get();
        return view('admin.laporan.top_pelanggan_web', compact('topUsers'));
    }

    public function laporanTopPelangganPdf()
    {
        $topUsers = User::where('role', 'pelanggan')
            ->withCount(['pesanan' => function($q) { $q->where('status', 'Selesai'); }])
            ->withSum(['pesanan' => function($q) { $q->where('status', 'Selesai'); }], 'total_bayar')
            ->having('pesanan_count', '>', 0)
            ->orderBy('pesanan_sum_total_bayar', 'DESC')
            ->take(10)
            ->get();
        $pdf = Pdf::loadView('admin.laporan.top_pelanggan_pdf', compact('topUsers'));
        return $pdf->stream('Laporan-Top-Pelanggan.pdf');
    }

    public function laporanPembatalan()
    {
        $pembatalan = Pesanan::with('user')->where('status', 'Dibatalkan')->latest()->get();
        return view('admin.laporan.pembatalan_web', compact('pembatalan'));
    }

    public function laporanPembatalanPdf()
    {
        $pembatalan = Pesanan::with('user')->where('status', 'Dibatalkan')->latest()->get();
        $pdf = Pdf::loadView('admin.laporan.pembatalan_pdf', compact('pembatalan'));
        return $pdf->stream('Laporan-Pembatalan.pdf');
    }

    public function laporanStok()
    {
        $bahan = BahanBaku::all();
        return view('admin.laporan.stok_web', compact('bahan'));
    }

    public function laporanStokPdf()
    {
        $bahan = BahanBaku::all();
        $pdf = Pdf::loadView('admin.laporan.stok_pdf', compact('bahan'))->setPaper('a4', 'portrait');
        return $pdf->stream('Laporan-Stok-Bahan-Baku-Orbit.pdf');
    }

    public function laporanStokBarang()
    {
        $produk = \App\Models\Produk::with('bahanBaku')->get();
        return view('admin.laporan.stok_barang_web', compact('produk'));
    }

    public function laporanStokBarangPdf()
    {
        $produk = \App\Models\Produk::with('bahanBaku')->get();
        $pdf = Pdf::loadView('admin.laporan.stok_barang_pdf', compact('produk'))->setPaper('a4', 'portrait');
        return $pdf->stream('Laporan-Stok-Barang-Orbit.pdf');
    }

    public function laporanRetur()
    {
        $semuaPesanan = Pesanan::with('user')->latest()->get();
        $totalOrder = $semuaPesanan->count();
        $totalOmzet = $semuaPesanan->where('status', 'Selesai')->sum('total_bayar');
        $orderAktif = $semuaPesanan->whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();
        $perStatus = $semuaPesanan->groupBy('status')->map(function($items, $status) {
            return ['jumlah' => $items->count(), 'total' => $items->sum('total_bayar')];
        })->toArray();
        $perBulan = $semuaPesanan->groupBy(function($item) {
            return $item->created_at->format('Y-m');
        })->map(function($items, $bulan) {
            return [
                'label' => \Carbon\Carbon::parse($bulan.'-01')->translatedFormat('F Y'),
                'jumlah' => $items->count(),
                'total' => $items->sum('total_bayar'),
            ];
        })->values()->take(6);
        $pesananTerbaru = $semuaPesanan->take(10);
        return view('admin.laporan.retur_web', compact('semuaPesanan', 'totalOrder', 'totalOmzet', 'orderAktif', 'perStatus', 'perBulan', 'pesananTerbaru'));
    }

    public function laporanReturPdf()
    {
        $semuaPesanan = Pesanan::with('user')->latest()->get();
        $totalOrder = $semuaPesanan->count();
        $totalOmzet = $semuaPesanan->where('status', 'Selesai')->sum('total_bayar');
        $orderAktif = $semuaPesanan->whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();
        $perStatus = $semuaPesanan->groupBy('status')->map(function($items, $status) {
            return ['jumlah' => $items->count(), 'total' => $items->sum('total_bayar')];
        })->toArray();
        $perBulan = $semuaPesanan->groupBy(function($item) {
            return $item->created_at->format('Y-m');
        })->map(function($items, $bulan) {
            return [
                'label' => \Carbon\Carbon::parse($bulan.'-01')->translatedFormat('F Y'),
                'jumlah' => $items->count(),
                'total' => $items->sum('total_bayar'),
            ];
        })->values()->take(6);
        $pesananTerbaru = $semuaPesanan->take(10);
        $pdf = Pdf::loadView('admin.laporan.retur_pdf', compact('semuaPesanan', 'totalOrder', 'totalOmzet', 'orderAktif', 'perStatus', 'perBulan', 'pesananTerbaru'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream('Monitoring-Pesanan-Orbit.pdf');
    }
}