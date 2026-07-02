<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [];

        $stats['pesanan_aktif'] = Pesanan::whereNotIn('status', ['Selesai', 'Dibatalkan', 'Verifikasi'])->count();
        $stats['pesanan_selesai'] = Pesanan::where('status', 'Selesai')->count();

        $stats['omzet_7_hari'] = Pesanan::where('status', 'Selesai')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_bayar) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal');

        $stats['status_counts'] = Pesanan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', compact('stats'));
    }
}