<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->boolean('konfirmasi_pelanggan')->default(false)->after('bukti_bayar');
            $table->string('bukti_konfirmasi')->nullable()->after('konfirmasi_pelanggan');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['konfirmasi_pelanggan', 'bukti_konfirmasi']);
        });
    }
};
