<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\BahanBakuController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\BahanMasukKeluarController;
use App\Http\Controllers\Admin\PengeluaranOperasionalController;
use App\Http\Controllers\Public\KatalogController;
use App\Http\Controllers\Public\PesananController;
use App\Http\Controllers\Public\UlasanController;
use Illuminate\Support\Facades\Route;
use App\Models\Produk;

Route::get('/', function () {
    $produk = Produk::with('bahanBaku')->take(4)->get();
    return view('welcome', compact('produk'));
});

Route::get('/katalog-layanan', [KatalogController::class, 'index'])->name('katalog.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pesan/{produk}', [PesananController::class, 'show'])->name('pesan.show');
    Route::post('/pesan/{produk}/keranjang', [PesananController::class, 'addToCart'])->name('pesan.cart');
    Route::get('/keranjang', [PesananController::class, 'cartIndex'])->name('keranjang.index');
    Route::delete('/keranjang/{detailKeranjang}', [PesananController::class, 'destroyCartItem'])->name('keranjang.destroy');
    Route::get('/keranjang/{detailKeranjang}/edit', [PesananController::class, 'editCartItem'])->name('keranjang.edit');
    Route::put('/keranjang/{detailKeranjang}', [PesananController::class, 'updateCartItem'])->name('keranjang.update');
    Route::get('/checkout', [PesananController::class, 'checkout'])->name('pesan.checkout');
    Route::post('/checkout/proses', [PesananController::class, 'storeCheckout'])->name('pesan.storeCheckout');
    
    Route::get('/riwayat-pesanan', [PesananController::class, 'riwayat'])->name('pesanan.riwayat');
    Route::get('/riwayat-pesanan/{id}', [PesananController::class, 'showRiwayat'])->name('pesanan.detail');
    Route::get('/riwayat-pesanan/{id}/cetak', [PesananController::class, 'cetakInvoice'])->name('pesanan.cetak');
    Route::post('/pesanan/{id}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
});

// Pegawai Dashboard (akses untuk admin & pegawai)
Route::middleware(['auth', 'admin'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');
});

// Admin Routes (akses untuk admin & pegawai)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Data Pegawai (hanya admin)
    Route::resource('pegawai', PegawaiController::class)->except(['create', 'show', 'edit']);
    
    // Data Pelanggan
    Route::resource('pelanggan', PelangganController::class)->except(['create', 'edit']);
    
    // Data Supplier
    Route::resource('supplier', SupplierController::class)->except(['create', 'show', 'edit']);
    
    // Data Produk
    Route::resource('produk', ProdukController::class);
    Route::post('/produk/{id}/formula', [ProdukController::class, 'updateFormula'])->name('produk.formula');
    
    // Data Bahan Baku
    Route::resource('bahan', BahanBakuController::class)->except(['create', 'show', 'edit']);
    Route::post('/bahan/{id}/restock', [BahanBakuController::class, 'restock'])->name('bahan.restock');
    
    // Bahan Masuk & Bahan Keluar
    Route::get('/bahan-masuk-keluar', [BahanMasukKeluarController::class, 'index'])->name('bahan-masuk-keluar.index');
    Route::post('/bahan-masuk-keluar', [BahanMasukKeluarController::class, 'store'])->name('bahan-masuk-keluar.store');
    
    // Data Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    
    // Pengeluaran Operasional
    Route::resource('pengeluaran-operasional', PengeluaranOperasionalController::class)->except(['create', 'show', 'edit']);
    
    // Pesanan (Order Management)
    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [AdminPesananController::class, 'show'])->name('pesanan.show');
    Route::patch('/pesanan/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::get('/pesanan-selesai', [AdminPesananController::class, 'selesai'])->name('pesanan.selesai');
    
    Route::get('/pesanan/{id}/cetak-label', [AdminPesananController::class, 'cetakLabel'])->name('pesanan.cetakLabel');
    Route::get('/pesanan/{id}/cetak-spk', [AdminPesananController::class, 'cetakSPK'])->name('pesanan.cetakSPK');

    // Laporan PDF
    Route::get('/laporan/penjualan', [AdminPesananController::class, 'laporanPenjualan'])->name('laporan.penjualan');
    Route::get('/laporan/bahan', [AdminPesananController::class, 'laporanBahan'])->name('laporan.bahan');
    Route::get('/laporan/terlaris', [AdminPesananController::class, 'laporanTerlaris'])->name('laporan.terlaris');
    Route::get('/laporan/top-pelanggan', [AdminPesananController::class, 'laporanTopPelanggan'])->name('laporan.topPelanggan');
    Route::get('/laporan/pembatalan', [AdminPesananController::class, 'laporanPembatalan'])->name('laporan.pembatalan');
    Route::get('/laporan/stok', [AdminPesananController::class, 'laporanStok'])->name('laporan.stok');
    Route::get('/laporan/stok-barang', [AdminPesananController::class, 'laporanStokBarang'])->name('laporan.stokBarang');
    Route::get('/laporan/retur', [AdminPesananController::class, 'laporanRetur'])->name('laporan.retur');
    
    // Keep old route alias for backward compatibility
    Route::get('/karyawan', [PegawaiController::class, 'index'])->name('karyawan.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
