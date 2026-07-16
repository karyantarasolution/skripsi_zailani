<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PegawaiDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [];

        $stats['pesanan_aktif'] = Pesanan::whereNotIn('status', ['Selesai', 'Dibatalkan', 'Verifikasi'])->count();
        $stats['pesanan_selesai'] = Pesanan::where('status', 'Selesai')->count();
        $stats['total_pelanggan'] = User::where('role', 'pelanggan')->count();

        $stats['pesanan_terbaru'] = Pesanan::with('user')
            ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->latest()
            ->take(5)
            ->get();

        $stats['pesanan_selesai_list'] = Pesanan::with('user')
            ->where('status', 'Selesai')
            ->latest()
            ->take(5)
            ->get();

        $stats['stok_menipis'] = \App\Models\BahanBaku::whereColumn('stok', '<=', 'minimum_stok')->count();

        $profileCompletion = 0;
        $totalFields = 12;
        $filledFields = 0;
        if ($user->nik) $filledFields++;
        if ($user->tempat_lahir) $filledFields++;
        if ($user->tanggal_lahir) $filledFields++;
        if ($user->jenis_kelamin) $filledFields++;
        if ($user->agama) $filledFields++;
        if ($user->status_kawin) $filledFields++;
        if ($user->telepon) $filledFields++;
        if ($user->alamat) $filledFields++;
        if ($user->kelurahan) $filledFields++;
        if ($user->kecamatan) $filledFields++;
        if ($user->kabupaten) $filledFields++;
        if ($user->provinsi) $filledFields++;
        $stats['profile_completion'] = round(($filledFields / $totalFields) * 100);

        return view('pegawai.dashboard', compact('stats', 'user'));
    }
}
