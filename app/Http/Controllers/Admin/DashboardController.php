<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\BahanBaku;
use App\Models\PengeluaranOperasional;
use App\Models\User;
use App\Models\RiwayatLogin;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [];
        $user = Auth::user();

        // Stat umum
        $stats['pesanan_aktif'] = Pesanan::whereNotIn('status', ['Selesai', 'Dibatalkan', 'Verifikasi'])->count();
        $stats['pesanan_selesai'] = Pesanan::where('status', 'Selesai')->count();
        $stats['total_pelanggan'] = User::where('role', 'pelanggan')->count();
        $stats['total_pegawai'] = User::whereIn('role', ['admin', 'pegawai'])->count();

        // Stok menipis (notifikasi stok minimum)
        $stats['stok_menipis'] = BahanBaku::whereColumn('stok', '<=', 'minimum_stok')->get();
        $stats['total_stok_kritis'] = $stats['stok_menipis']->count();

        // Omzet 7 hari
        $stats['omzet_7_hari'] = Pesanan::where('status', 'Selesai')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_bayar) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal');

        // Status counts
        $stats['status_counts'] = Pesanan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Pengeluaran per kategori (bulan ini)
        $stats['pengeluaran_bulan_ini'] = PengeluaranOperasional::whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->sum('jumlah');

        $stats['pengeluaran_per_kategori'] = PengeluaranOperasional::whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->selectRaw('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        // Grafik pengeluaran 7 hari
        $stats['pengeluaran_7_hari'] = PengeluaranOperasional::whereDate('tanggal', '>=', now()->subDays(6))
            ->selectRaw('DATE(tanggal) as tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal');

        // Riwayat login terkini (untuk admin)
        $stats['riwayat_login'] = RiwayatLogin::with('user')
            ->where('tipe', 'login')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats'));
    }
}
