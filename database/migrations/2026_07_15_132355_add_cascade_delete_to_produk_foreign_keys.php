<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_pesanan', function (Blueprint $table) {
            $table->dropForeign('detail_pesanan_produk_id_foreign');
            $table->foreign('produk_id')->references('id')->on('produk')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('detail_pesanan', function (Blueprint $table) {
            $table->dropForeign('detail_pesanan_produk_id_foreign');
            $table->foreign('produk_id')->references('id')->on('produk');
        });
    }
};
