<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use App\Models\RiwayatStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BahanBakuController extends Controller
{
    public function index()
    {
        // Ambil data bahan baku sekaligus riwayatnya (untuk ditampilkan di modal audit)
        $bahan = BahanBaku::with(['riwayatStok' => function($q) {
            $q->latest()->take(10); // Ambil 10 histori terakhir
        }, 'riwayatStok.user'])->latest()->get();
        
        return view('admin.bahan.index', compact('bahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barcode' => 'nullable|string|unique:bahan_baku',
            'nama_bahan' => 'required|string',
            'stok' => 'required|integer|min:0',
            'minimum_stok' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'supplier' => 'nullable|string',
        ]);

        $bahan = BahanBaku::create($request->all());

        // Catat Otomatis ke Histori Stok Awal
        RiwayatStok::create([
            'bahan_baku_id' => $bahan->id,
            'user_id' => Auth::id(),
            'jenis' => 'masuk',
            'jumlah' => $request->stok,
            'stok_sebelum' => 0,
            'stok_sesudah' => $request->stok,
            'keterangan' => 'Input Stok Awal Sistem'
        ]);

        return back()->with('success', 'Bahan Baku & Barcode berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);
        
        // Pada fungsi edit, hanya update identitas barang. Stok diupdate via Restock.
        $bahan->update($request->only(['kode_barcode', 'nama_bahan', 'minimum_stok', 'satuan', 'supplier']));
        
        return back()->with('success', 'Detail Bahan Baku berhasil diupdate!');
    }

    public function destroy($id)
    {
        BahanBaku::findOrFail($id)->delete();
        return back()->with('success', 'Bahan Baku berhasil dihapus!');
    }

    // FUNGSI BARU: RESTOCK & AUDIT
    public function restock(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'jenis' => 'required|in:masuk,keluar,penyesuaian',
            'keterangan' => 'nullable|string'
        ]);

        $bahan = BahanBaku::findOrFail($id);
        $stok_sebelum = $bahan->stok;
        
        // Kalkulasi metode Inventory (Tambah/Kurang/Penyesuaian)
        if($request->jenis == 'masuk') {
            $stok_sesudah = $stok_sebelum + $request->jumlah;
        } elseif($request->jenis == 'penyesuaian') {
            $stok_sesudah = $request->jumlah; // Penyesuaian = stok aktual (opname)
        } else {
            $stok_sesudah = $stok_sebelum - $request->jumlah;
            if($stok_sesudah < 0) $stok_sesudah = 0; // Cegah stok minus
        }

        // Update Stok Utama
        $bahan->update(['stok' => $stok_sesudah]);

        // Catat ke Log Audit Histori
        RiwayatStok::create([
            'bahan_baku_id' => $bahan->id,
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'stok_sebelum' => $stok_sebelum,
            'stok_sesudah' => $stok_sesudah,
            'keterangan' => $request->keterangan ?? 'Update Manual Gudang'
        ]);

        return back()->with('success', 'Pergerakan Stok berhasil dicatat di sistem Audit!');
    }
}