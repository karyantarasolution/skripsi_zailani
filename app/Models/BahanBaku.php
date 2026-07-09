<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model {
    protected $table = 'bahan_baku';
    protected $fillable = ['nama_bahan', 'kode_barcode', 'stok', 'minimum_stok', 'satuan', 'supplier', 'supplier_id'];

    public function riwayatStok()
    {
        return $this->hasMany(RiwayatStok::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
