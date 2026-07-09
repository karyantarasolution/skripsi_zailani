<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatLogin extends Model
{
    protected $table = 'riwayat_logins';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'tipe',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
