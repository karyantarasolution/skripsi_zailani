<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengeluaranOperasional extends Model
{
    protected $fillable = [
        'kategori',
        'deskripsi',
        'jumlah',
        'tanggal',
        'bukti',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public static $kategoriList = [
        'Listrik',
        'Air',
        'Internet',
        'Sewa Gedung',
        'Servis Mesin',
        'Bensin/Transport',
        'ATK',
        'Kebersihan',
        'Konsumsi',
        'Lainnya',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
