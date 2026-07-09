<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('nomor_invoice', 'like', '%'.$request->cari.'%')
                  ->orWhereHas('user', function($uq) use ($request) {
                      $uq->where('name', 'like', '%'.$request->cari.'%');
                  });
            });
        }

        $transaksi = $query->latest()->paginate(15)->withQueryString();

        $totalOmzet = Pesanan::where('status', 'Selesai')->sum('total_bayar');
        $totalPending = Pesanan::where('status', 'Menunggu Pembayaran')->count();

        return view('admin.transaksi.index', compact('transaksi', 'totalOmzet', 'totalPending'));
    }

    public function show($id)
    {
        $transaksi = Pesanan::with(['user', 'detailPesanan.produk', 'riwayatPesanan'])->findOrFail($id);
        return view('admin.transaksi.show', compact('transaksi'));
    }
}
