<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BahanBaku;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\PengeluaranOperasional;
use App\Models\RiwayatStok;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\RiwayatPesanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    // ===================== USERS =====================
    User::create([
      'name' => 'Zailani Admin', 'username' => 'admin', 'email' => 'admin@orbit.com',
      'password' => Hash::make('password'), 'role' => 'admin',
      'nip' => 'ADM-001', 'jabatan' => 'Manager', 'telepon' => '08110000001',
      'alamat' => 'Kantor Pusat Orbit Print', 'jenis_kelamin' => 'L', 'tanggal_bergabung' => now(),
    ]);

    $pegawai = User::create([
      'name' => 'Rina Pegawai', 'username' => 'pegawai', 'email' => 'pegawai@orbit.com',
      'password' => Hash::make('password'), 'role' => 'pegawai',
      'nip' => 'PEG-001', 'jabatan' => 'Kasir', 'telepon' => '08110000002',
      'alamat' => 'Orbit Print Banjarmasin', 'jenis_kelamin' => 'P', 'tanggal_bergabung' => now(),
    ]);

    User::create([
      'name' => 'Hendra Desainer', 'username' => 'hendra', 'email' => 'hendra@orbit.com',
      'password' => Hash::make('password'), 'role' => 'pegawai',
      'nip' => 'PEG-002', 'jabatan' => 'Desainer Grafis', 'telepon' => '08110000005',
      'alamat' => 'Jl. Pangeran Antasari No. 45, Banjarmasin', 'jenis_kelamin' => 'L', 'tanggal_bergabung' => now()->subMonths(6),
    ]);

    User::create([
      'name' => 'Sari Produksi', 'username' => 'sari', 'email' => 'sari@orbit.com',
      'password' => Hash::make('password'), 'role' => 'pegawai',
      'nip' => 'PEG-003', 'jabatan' => 'Operator Produksi', 'telepon' => '08110000006',
      'alamat' => 'Jl. Kelayan A No. 12, Banjarmasin', 'jenis_kelamin' => 'P', 'tanggal_bergabung' => now()->subMonths(3),
    ]);

    $pelanggan1 = User::create([
      'name' => 'Budi Pelanggan', 'username' => 'budi', 'email' => 'budi@gmail.com',
      'password' => Hash::make('password'), 'role' => 'pelanggan',
      'telepon' => '08110000003', 'alamat' => 'Jl. Sultan Adam Banjarmasin',
      'jenis_kelamin' => 'L', 'poin' => 150, 'tanggal_bergabung' => now()->subMonths(12),
    ]);

    $pelanggan2 = User::create([
      'name' => 'Siti Pelanggan', 'username' => 'siti', 'email' => 'siti@gmail.com',
      'password' => Hash::make('password'), 'role' => 'pelanggan',
      'telepon' => '08110000004', 'alamat' => 'Jl. Ahmad Yani Banjarmasin',
      'jenis_kelamin' => 'P', 'poin' => 75, 'tanggal_bergabung' => now()->subMonths(8),
    ]);

    $pelanggan3 = User::create([
      'name' => 'Ahmad Fauzi', 'username' => 'ahmad', 'email' => 'ahmad@gmail.com',
      'password' => Hash::make('password'), 'role' => 'pelanggan',
      'telepon' => '08120000001', 'alamat' => 'Jl. Hasan Basri No. 30, Banjarmasin',
      'jenis_kelamin' => 'L', 'poin' => 220, 'tanggal_bergabung' => now()->subMonths(6),
    ]);

    $pelanggan4 = User::create([
      'name' => 'Dewi Sartika', 'username' => 'dewi', 'email' => 'dewi@gmail.com',
      'password' => Hash::make('password'), 'role' => 'pelanggan',
      'telepon' => '08120000002', 'alamat' => 'Jl. Belitung Darat No. 8, Banjarmasin',
      'jenis_kelamin' => 'P', 'poin' => 45, 'tanggal_bergabung' => now()->subMonths(2),
    ]);

    $pelanggan5 = User::create([
      'name' => 'Rizky Pratama', 'username' => 'rizky', 'email' => 'rizky@gmail.com',
      'password' => Hash::make('password'), 'role' => 'pelanggan',
      'telepon' => '08120000003', 'alamat' => 'Jl. A. Yani KM 4,5 Banjarmasin',
      'jenis_kelamin' => 'L', 'poin' => 310, 'tanggal_bergabung' => now()->subMonths(18),
    ]);

    $pelanggan6 = User::create([
      'name' => 'Maya Indah', 'username' => 'maya', 'email' => 'maya@gmail.com',
      'password' => Hash::make('password'), 'role' => 'pelanggan',
      'telepon' => '08120000004', 'alamat' => 'Jl. Veteran No. 15, Banjarmasin',
      'jenis_kelamin' => 'P', 'poin' => 90, 'tanggal_bergabung' => now()->subMonths(4),
    ]);

    $pelanggan7 = User::create([
      'name' => 'Hasan Basri', 'username' => 'hasan', 'email' => 'hasan@gmail.com',
      'password' => Hash::make('password'), 'role' => 'pelanggan',
      'telepon' => '08120000005', 'alamat' => 'Jl. Cempaka Besar No. 22, Banjarmasin',
      'jenis_kelamin' => 'L', 'poin' => 180, 'tanggal_bergabung' => now()->subMonths(10),
    ]);

    // ===================== SUPPLIER =====================
    $supplier1 = Supplier::create([
      'nama_supplier' => 'PT. Kertas Indonesia', 'kontak_person' => 'Bambang',
      'telepon' => '021-5550123', 'email' => 'bambang@kertasindo.co.id',
      'alamat' => 'Jakarta Pusat', 'bank' => 'BCA', 'nomor_rekening' => '1234567890',
    ]);
    $supplier2 = Supplier::create([
      'nama_supplier' => 'CV. Bahan Printing', 'kontak_person' => 'Dewi',
      'telepon' => '031-5550456', 'email' => 'dewi@bahanprinting.com',
      'alamat' => 'Surabaya', 'bank' => 'Mandiri', 'nomor_rekening' => '0987654321',
    ]);
    $supplier3 = Supplier::create([
      'nama_supplier' => 'UD. Tinta Abadi', 'kontak_person' => 'Agus',
      'telepon' => '0511-1234567', 'email' => 'agus@tintaabadi.co.id',
      'alamat' => 'Jl. Pasar Lama No. 5, Banjarmasin', 'bank' => 'BRI', 'nomor_rekening' => '5551234567',
    ]);
    $supplier4 = Supplier::create([
      'nama_supplier' => 'CV. Alat Cetak Jaya', 'kontak_person' => 'Wati',
      'telepon' => '031-5550789', 'email' => 'wati@alatcetakjaya.com',
      'alamat' => 'Surabaya', 'bank' => 'BNI', 'nomor_rekening' => '8887654321',
    ]);

    // ===================== BAHAN BAKU =====================
    $bahanFlexi = BahanBaku::create(['nama_bahan' => 'Flexi Standar', 'stok' => 450, 'minimum_stok' => 50, 'satuan' => 'm2', 'supplier_id' => $supplier2->id, 'supplier' => 'CV. Bahan Printing']);
    $bahanKertas = BahanBaku::create(['nama_bahan' => 'Art Paper / Chrome', 'stok' => 850, 'minimum_stok' => 100, 'satuan' => 'lembar', 'supplier_id' => $supplier1->id, 'supplier' => 'PT. Kertas Indonesia']);
    $bahanSticker = BahanBaku::create(['nama_bahan' => 'Vinyl/Sticker', 'stok' => 180, 'minimum_stok' => 30, 'satuan' => 'm2', 'supplier_id' => $supplier2->id, 'supplier' => 'CV. Bahan Printing']);
    $bahanLain = BahanBaku::create(['nama_bahan' => 'Material Custom', 'stok' => 85, 'minimum_stok' => 20, 'satuan' => 'pcs']);
    $bahanTinta = BahanBaku::create(['nama_bahan' => 'Tinta Eco-Solvent', 'stok' => 12, 'minimum_stok' => 15, 'satuan' => 'botol', 'supplier_id' => $supplier3->id, 'supplier' => 'UD. Tinta Abadi']);
    $bahanKartas = BahanBaku::create(['nama_bahan' => 'Kertas Ivory 310gr', 'stok' => 500, 'minimum_stok' => 80, 'satuan' => 'lembar', 'supplier_id' => $supplier1->id, 'supplier' => 'PT. Kertas Indonesia']);
    $bahanAkrilik = BahanBaku::create(['nama_bahan' => 'Akrilik 3mm', 'stok' => 8, 'minimum_stok' => 10, 'satuan' => 'lembar', 'supplier_id' => $supplier4->id, 'supplier' => 'CV. Alat Cetak Jaya']);
    $bahanKain = BahanBaku::create(['nama_bahan' => 'Kain Polyester', 'stok' => 60, 'minimum_stok' => 20, 'satuan' => 'meter', 'supplier_id' => $supplier4->id, 'supplier' => 'CV. Alat Cetak Jaya']);

    // ===================== PRODUK =====================
    $dataProduk = [
      ['nama' => 'Cetak Banner/Cetak Spanduk/Cetak Baliho', 'harga' => 60000, 'bahan' => $bahanFlexi->id],
      ['nama' => 'Umbul Umbul Custom/Bendera Custom', 'harga' => 70000, 'bahan' => $bahanFlexi->id],
      ['nama' => 'Cetak Custom Backdrop', 'harga' => 60000, 'bahan' => $bahanFlexi->id],
      ['nama' => 'X/Y Banner Custom', 'harga' => 120000, 'bahan' => $bahanLain->id],
      ['nama' => 'Undangan Custom', 'harga' => 10000, 'bahan' => $bahanKertas->id],
      ['nama' => 'Stempel Custom/Stempel Flash', 'harga' => 120000, 'bahan' => $bahanLain->id],
      ['nama' => 'Id Card & Lanyard Custom', 'harga' => 70000, 'bahan' => $bahanLain->id],
      ['nama' => 'Cetak Sticker Custom', 'harga' => 40000, 'bahan' => $bahanSticker->id],
      ['nama' => 'Cetak Brosur A4', 'harga' => 16500, 'bahan' => $bahanKertas->id],
      ['nama' => 'MUG Custom', 'harga' => 65000, 'bahan' => $bahanLain->id],
      ['nama' => 'Kaos Sablon Custom', 'harga' => 120000, 'bahan' => $bahanLain->id],
      ['nama' => 'Cetak Kartu Nama', 'harga' => 35000, 'bahan' => $bahanKartas->id],
      ['nama' => 'Cetak Kalender Meja', 'harga' => 45000, 'bahan' => $bahanKartas->id],
      ['nama' => 'Akrilik Signage', 'harga' => 150000, 'bahan' => $bahanAkrilik->id],
      ['nama' => 'Cetak Kaos DTG', 'harga' => 95000, 'bahan' => $bahanKain->id],
    ];
    $produkIds = [];
    foreach ($dataProduk as $item) {
      $p = Produk::create([
        'bahan_baku_id' => $item['bahan'],
        'nama_produk' => $item['nama'],
        'harga_dasar' => $item['harga'],
        'deskripsi' => 'Produk cetak berkualitas dari Orbit Print.',
      ]);
      $produkIds[] = $p->id;
    }

    // ===================== RIWAYAT STOK (Bahan Masuk/Keluar) =====================
    $bahanIds = [$bahanFlexi->id, $bahanKertas->id, $bahanSticker->id, $bahanTinta->id, $bahanAkrilik->id];
    $stokSaatIni = [450, 850, 180, 12, 8];

    $riwayatData = [
      // Bahan Masuk (restock)
      ['bahan' => $bahanFlexi->id, 'jenis' => 'masuk', 'jumlah' => 100, 'stok_sebelum' => 400, 'stok_sesudah' => 500, 'keterangan' => 'Restock dari supplier', 'hari_lalu' => 14],
      ['bahan' => $bahanFlexi->id, 'jenis' => 'masuk', 'jumlah' => 50, 'stok_sebelum' => 450, 'stok_sesudah' => 500, 'keterangan' => 'Restock', 'hari_lalu' => 7],
      ['bahan' => $bahanKertas->id, 'jenis' => 'masuk', 'jumlah' => 300, 'stok_sebelum' => 700, 'stok_sesudah' => 1000, 'keterangan' => 'Restock dari PT. Kertas Indonesia', 'hari_lalu' => 10],
      ['bahan' => $bahanKertas->id, 'jenis' => 'masuk', 'jumlah' => 150, 'stok_sebelum' => 850, 'stok_sesudah' => 1000, 'keterangan' => 'Restock', 'hari_lalu' => 3],
      ['bahan' => $bahanSticker->id, 'jenis' => 'masuk', 'jumlah' => 50, 'stok_sebelum' => 150, 'stok_sesudah' => 200, 'keterangan' => 'Restock vinyl', 'hari_lalu' => 5],
      ['bahan' => $bahanTinta->id, 'jenis' => 'masuk', 'jumlah' => 5, 'stok_sebelum' => 10, 'stok_sesudah' => 15, 'keterangan' => 'Restock tinta eco-solvent', 'hari_lalu' => 2],
      // Bahan Keluar (pemakaian)
      ['bahan' => $bahanFlexi->id, 'jenis' => 'keluar', 'jumlah' => 30, 'stok_sebelum' => 500, 'stok_sesudah' => 470, 'keterangan' => 'Produksi banner customer', 'hari_lalu' => 6],
      ['bahan' => $bahanFlexi->id, 'jenis' => 'keluar', 'jumlah' => 20, 'stok_sebelum' => 470, 'stok_sesudah' => 450, 'keterangan' => 'Produksi backdrop event', 'hari_lalu' => 1],
      ['bahan' => $bahanKertas->id, 'jenis' => 'keluar', 'jumlah' => 100, 'stok_sebelum' => 1000, 'stok_sesudah' => 900, 'keterangan' => 'Cetak brosur dan undangan', 'hari_lalu' => 8],
      ['bahan' => $bahanKertas->id, 'jenis' => 'keluar', 'jumlah' => 50, 'stok_sebelum' => 900, 'stok_sesudah' => 850, 'keterangan' => 'Cetak kartu nama customer', 'hari_lalu' => 2],
      ['bahan' => $bahanSticker->id, 'jenis' => 'keluar', 'jumlah' => 20, 'stok_sebelum' => 200, 'stok_sesudah' => 180, 'keterangan' => 'Produksi stiker custom', 'hari_lalu' => 4],
      ['bahan' => $bahanTinta->id, 'jenis' => 'keluar', 'jumlah' => 3, 'stok_sebelum' => 15, 'stok_sesudah' => 12, 'keterangan' => 'Pemakaian produksi', 'hari_lalu' => 1],
      ['bahan' => $bahanAkrilik->id, 'jenis' => 'keluar', 'jumlah' => 2, 'stok_sebelum' => 10, 'stok_sesudah' => 8, 'keterangan' => 'Produksi signage akrilik', 'hari_lalu' => 3],
    ];

    foreach ($riwayatData as $r) {
      $tgl = now()->subDays($r['hari_lalu']);
      RiwayatStok::create([
        'bahan_baku_id' => $r['bahan'],
        'user_id' => $pegawai->id,
        'jenis' => $r['jenis'],
        'jumlah' => $r['jumlah'],
        'stok_sebelum' => $r['stok_sebelum'],
        'stok_sesudah' => $r['stok_sesudah'],
        'keterangan' => $r['keterangan'],
        'created_at' => $tgl,
        'updated_at' => $tgl,
      ]);
    }

    // ===================== PENGELUARAN OPERASIONAL =====================
    $pengeluaranTemplates = [
      ['kategori' => 'Listrik', 'deskripsi' => 'Tagihan listrik bulan', 'jumlah' => 1500000],
      ['kategori' => 'Internet', 'deskripsi' => 'Paket WiFi Bulanan', 'jumlah' => 500000],
      ['kategori' => 'ATK', 'deskripsi' => 'Kertas HVS, tinta, alat tulis', 'jumlah' => 350000],
      ['kategori' => 'Sewa', 'deskripsi' => 'Sewa tempat usaha', 'jumlah' => 3000000],
      ['kategori' => 'Gaji', 'deskripsi' => 'Gaji pegawai', 'jumlah' => 4500000],
      ['kategori' => 'Transportasi', 'deskripsi' => 'Biaya kirim bahan baku', 'jumlah' => 200000],
      ['kategori' => 'Maintenance', 'deskripsi' => 'Servis mesin cetak', 'jumlah' => 750000],
      ['kategori' => 'Pemasaran', 'deskripsi' => 'Biaya iklan dan promosi', 'jumlah' => 300000],
    ];

    $no = 0;
    for ($bulan = 5; $bulan <= 7; $bulan++) {
      foreach ($pengeluaranTemplates as $pt) {
        $no++;
        if ($no > 20) break;
        $tgl = now()->setMonth($bulan)->setDay(min(rand(1, 28), 28))->setHour(rand(8, 16))->setMinute(0);
        $variasi = rand(-200000, 200000);
        PengeluaranOperasional::create([
          'kategori' => $pt['kategori'],
          'deskripsi' => $pt['deskripsi'] . ' ' . $tgl->translatedFormat('F Y'),
          'jumlah' => max(50000, $pt['jumlah'] + $variasi),
          'tanggal' => $tgl,
          'user_id' => 1,
          'created_at' => $tgl,
          'updated_at' => $tgl,
        ]);
      }
    }

    // Tambahan pengeluaran random untuk 7 hari terakhir
    for ($i = 0; $i < 10; $i++) {
      $tgl = now()->subDays(rand(0, 6));
      $kategori = ['Listrik', 'ATK', 'Transportasi', 'Maintenance', 'Pemasaran'][array_rand(['Listrik', 'ATK', 'Transportasi', 'Maintenance', 'Pemasaran'])];
      PengeluaranOperasional::create([
        'kategori' => $kategori,
        'deskripsi' => 'Pengeluaran ' . $kategori . ' - ' . $tgl->translatedFormat('d M'),
        'jumlah' => rand(50000, 500000),
        'tanggal' => $tgl,
        'user_id' => 1,
        'created_at' => $tgl,
        'updated_at' => $tgl,
      ]);
    }

    // ===================== PESANAN (Transaksi) =====================
    $pelangganIds = [$pelanggan1->id, $pelanggan2->id, $pelanggan3->id, $pelanggan4->id, $pelanggan5->id, $pelanggan6->id, $pelanggan7->id];
    $statuses = ['Menunggu Pembayaran', 'Verifikasi', 'Antrean Cetak', 'Produksi', 'Siap Ambil', 'Sedang Dikirim', 'Selesai', 'Dibatalkan'];

    for ($i = 1; $i <= 25; $i++) {
      $userId = $pelangganIds[array_rand($pelangganIds)];
      $status = $statuses[array_rand($statuses)];
      $hariLalu = rand(0, 30);
      $tglPesanan = now()->subDays($hariLalu);
      $totalHarga = rand(1, 5) * rand(50000, 200000);
      $diskon = rand(0, 1) ? rand(5000, 20000) : 0;
      $totalBayar = $totalHarga + 5000 - $diskon;

      $invoice = 'INV-' . $tglPesanan->format('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);

      $pesanan = Pesanan::create([
        'user_id' => $userId,
        'nomor_invoice' => $invoice,
        'total_harga' => $totalHarga,
        'potongan_diskon' => $diskon,
        'total_bayar' => $totalBayar,
        'metode_pengiriman' => rand(0, 1) ? 'Ambil di Toko' : 'Dikirim',
        'status' => $status,
        'created_at' => $tglPesanan,
        'updated_at' => $tglPesanan,
      ]);

      // Detail pesanan (1-3 item)
      $jmlItem = rand(1, 3);
      $subtotalItem = 0;
      for ($j = 0; $j < $jmlItem; $j++) {
        $produkId = $produkIds[array_rand($produkIds)];
        $qty = rand(1, 5);
        $produk = Produk::find($produkId);
        $harga = $produk ? $produk->harga_dasar : rand(10000, 100000);
        $subtotal = $harga * $qty;
        $subtotalItem += $subtotal;

        DetailPesanan::create([
          'pesanan_id' => $pesanan->id,
          'produk_id' => $produkId,
          'jumlah' => $qty,
          'panjang' => rand(50, 200),
          'lebar' => rand(30, 100),
          'subtotal' => $subtotal,
          'file_desain' => '',
          'created_at' => $tglPesanan,
          'updated_at' => $tglPesanan,
        ]);
      }

      // Update total harga sesuai detail
      $pesanan->update(['total_harga' => $subtotalItem, 'total_bayar' => $subtotalItem + 5000 - $diskon]);

      // Riwayat status pesanan
      RiwayatPesanan::create([
        'pesanan_id' => $pesanan->id,
        'status_log' => $status,
        'catatan' => 'Status: ' . $status,
        'created_at' => $tglPesanan,
        'updated_at' => $tglPesanan,
      ]);
    }
  }
}
