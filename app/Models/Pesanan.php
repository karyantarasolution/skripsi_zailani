<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'voucher_id',
        'nomor_invoice',
        'total_harga',
        'potongan_diskon',
        'total_bayar',
        'ongkir',
        'metode_pengiriman',
        'bukti_bayar',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // NAMA FUNGSI INI HARUS PERSIS: detailPesanan
  public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function riwayatPesanan()
    {
        return $this->hasMany(RiwayatPesanan::class, 'pesanan_id');
    }
}