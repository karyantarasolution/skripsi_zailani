<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\DetailKeranjang;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\DetailPesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoicePesananMail;
use Illuminate\Support\Facades\Log;
use App\Services\FonnteService;
use App\Models\User;
class PesananController extends Controller
{
public function show(Produk $produk)
{
    // Mengirim variabel $produk, bukan $pesanan
    return view('pesanan.show', compact('produk'));
}

    public function addToCart(Request $request, Produk $produk)
    {
        $minDim = $produk->satuan === 'mm' ? 1 : 0.01;

        $request->validate([
            'panjang' => 'required|numeric|min:' . $minDim,
            'lebar' => 'required|numeric|min:' . $minDim,
            'jumlah' => 'required|integer|min:1',
            'file_desain' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        try {
            $keranjang = Keranjang::firstOrCreate(
                ['user_id' => Auth::id(), 'status' => 'aktif']
            );

            $pathDesain = $request->hasFile('file_desain') ? $request->file('file_desain')->store('desain_pesanan', 'public') : null;

            $subtotal = $request->panjang * $request->lebar * $produk->harga_dasar * $request->jumlah;

            DetailKeranjang::create([
                'keranjang_id' => $keranjang->id,
                'produk_id' => $produk->id,
                'panjang' => $request->panjang,
                'lebar' => $request->lebar,
                'jumlah' => $request->jumlah,
                'subtotal' => $subtotal,
                'file_desain' => $pathDesain,
                'catatan' => $request->catatan,
            ]);

            return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan ke keranjang: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan ke keranjang. Silakan coba lagi.');
        }
    }

    public function cartIndex()
    {
        $keranjang = Keranjang::with('detailKeranjang.produk')
            ->where('user_id', Auth::id())
            ->where('status', 'aktif')
            ->first();

        return view('pesanan.cart', compact('keranjang'));
    }

    public function checkout()
    {
        $keranjang = Keranjang::with('detailKeranjang.produk')
            ->where('user_id', Auth::id())
            ->where('status', 'aktif')
            ->first();

        if (!$keranjang || $keranjang->detailKeranjang->isEmpty()) {
            return back()->with('error', 'Keranjang Anda kosong.');
        }

        $total_harga = $keranjang->detailKeranjang->sum('subtotal');
        $total_item = $keranjang->detailKeranjang->sum('jumlah');
        
        // Logika Diskon Grosir Otomatis: >= 5 pcs kedaikum 10% diskon
        $potongan_diskon = 0;
        if ($total_item >= 5) {
            $potongan_diskon = $total_harga * 0.10; // Diskon 10%
        }
        
        $total_bayar = $total_harga - $potongan_diskon;

        return view('pesanan.checkout', compact('keranjang', 'total_harga', 'potongan_diskon', 'total_bayar', 'total_item'));
    }

 public function storeCheckout(Request $request)
    {
        $request->validate([
            'bank_tujuan' => 'required|string',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'metode_pengiriman' => 'required|string|in:Ambil di Toko,Kurir Lokal',
        ]);

        $keranjang = Keranjang::with('detailKeranjang.produk')->where('user_id', Auth::id())->where('status', 'aktif')->first();
        
        $total_harga = $keranjang->detailKeranjang->sum('subtotal');
        $total_item = $keranjang->detailKeranjang->sum('jumlah');

        $potongan_diskon = 0;
        if ($total_item >= 5) {
            $potongan_diskon = $total_harga * 0.10;
        }
        $total_bayar = $total_harga - $potongan_diskon;

        $pathBukti = $request->file('bukti_bayar')->store('bukti_pembayaran', 'public');

        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'nomor_invoice' => 'INV-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5)),
            'total_harga' => $total_harga,
            'potongan_diskon' => $potongan_diskon,
            'total_bayar' => $total_bayar,
            'metode_pengiriman' => $request->metode_pengiriman . ' | Bayar via: ' . $request->bank_tujuan,
            'bukti_bayar' => $pathBukti,
            'status' => 'Verifikasi',
        ]);

        foreach ($keranjang->detailKeranjang as $detail) {
            \App\Models\DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'produk_id' => $detail->produk_id,
                'panjang' => $detail->panjang,
                'lebar' => $detail->lebar,
                'jumlah' => $detail->jumlah,
                'finishing' => $detail->catatan,
                'file_desain' => $detail->file_desain ?? '-',
                'subtotal' => $detail->subtotal,
            ]);
        }

        $keranjang->update(['status' => 'selesai']);

        try {
            Mail::to(Auth::user()->email)->send(new InvoicePesananMail($pesanan));
        } catch (\Exception $e) {
            Log::error('Gagal kirim email invoice: ' . $e->getMessage());
        }

        try {
            $fonnte = new FonnteService();
            $adminList = User::whereIn('role', ['super_admin', 'admin_kantor', 'kasir'])->get();

            $totalFormat = 'Rp ' . number_format($pesanan->total_bayar, 0, ',', '.');
            $items = $keranjang->detailKeranjang->map(fn($d) => ($d->produk->nama_produk ?? 'Produk') . ' (' . $d->jumlah . ' pcs)')->join(', ');

            $message = "*PESANAN BARU* 🖨️\n\n"
                . "Invoice: " . $pesanan->nomor_invoice . "\n"
                . "Pelanggan: " . Auth::user()->name . "\n"
                . "Item: " . $items . "\n"
                . "Total: " . $totalFormat . "\n"
                . "Pengiriman: " . $pesanan->metode_pengiriman . "\n\n"
                . "Segera verifikasi pembayaran di panel admin!\n"
                . url('/admin/pesanan/' . $pesanan->id);

            foreach ($adminList as $admin) {
                if (!empty($admin->telepon)) {
                    $fonnte->sendMessage($admin->telepon, $message);
                }
            }
        } catch (\Exception $e) {
            Log::error('Gagal kirim WA notif ke admin: ' . $e->getMessage());
        }

        return redirect()->route('pesanan.riwayat')->with('success', 'Pesanan berhasil dikirim & menunggu verifikasi Kasir! Invoice telah dikirim ke email Anda.');
    }
    // UPDATE fungsi riwayat agar memanggil detailPesanan
    public function riwayat()
    {
        $pesanan = Pesanan::with('detailPesanan.produk')
                          ->where('user_id', Auth::id())
                          ->latest()
                          ->get();

        return view('pesanan.riwayat', compact('pesanan'));
    }

    // FUNGSI BARU: Untuk tombol "Cek Detail"
public function showRiwayat($id)
{
    $pesanan = Pesanan::with(['detailPesanan.produk', 'user'])
                ->where('user_id', auth()->id())
                ->findOrFail($id);

    return view('pesanan.detail', compact('pesanan'));
}
public function cetakInvoice($id)
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.produk'])
                          ->where('user_id', Auth::id())
                          ->findOrFail($id);

        // Load view khusus untuk PDF
        $pdf = Pdf::loadView('pesanan.invoice_pdf', compact('pesanan'))
                  ->setPaper('a4', 'portrait');

        // Nama file saat didownload
        return $pdf->download('Invoice-' . $pesanan->nomor_invoice . '.pdf');
    }
}