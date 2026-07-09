<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatStok;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BahanMasukKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatStok::with(['bahanBaku', 'user']);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('bahan_id')) {
            $query->where('bahan_baku_id', $request->bahan_id);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $riwayat = $query->latest()->paginate(20)->withQueryString();
        $bahanList = BahanBaku::orderBy('nama_bahan')->get();

        // Statistik pergerakan
        $totalMasuk = RiwayatStok::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = RiwayatStok::where('jenis', 'keluar')->sum('jumlah');

        return view('admin.bahan-masuk-keluar.index', compact('riwayat', 'bahanList', 'totalMasuk', 'totalKeluar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bahan_baku_id' => 'required|exists:bahan_baku,id',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $bahan = BahanBaku::findOrFail($request->bahan_baku_id);
        $stok_sebelum = $bahan->stok;

        if ($request->jenis == 'masuk') {
            $stok_sesudah = $stok_sebelum + $request->jumlah;
        } else {
            $stok_sesudah = max(0, $stok_sebelum - $request->jumlah);
        }

        $bahan->update(['stok' => $stok_sesudah]);

        RiwayatStok::create([
            'bahan_baku_id' => $bahan->id,
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'stok_sebelum' => $stok_sebelum,
            'stok_sesudah' => $stok_sesudah,
            'keterangan' => $request->keterangan ?? ($request->jenis == 'masuk' ? 'Pembelian dari supplier' : 'Pemakaian produksi'),
        ]);

        return back()->with('success', 'Pergerakan stok berhasil dicatat!');
    }
}
