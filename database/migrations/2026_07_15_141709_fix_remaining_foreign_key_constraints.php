<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_keranjangs', function (Blueprint $table) {
            $table->dropForeign('detail_keranjangs_produk_id_foreign');
            $table->foreign('produk_id')->references('id')->on('produk')->cascadeOnDelete();
        });

        Schema::table('pengeluaran_operasionals', function (Blueprint $table) {
            $table->dropForeign('pengeluaran_operasionals_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('detail_keranjangs', function (Blueprint $table) {
            $table->dropForeign('detail_keranjangs_produk_id_foreign');
            $table->foreign('produk_id')->references('id')->on('produk');
        });

        Schema::table('pengeluaran_operasionals', function (Blueprint $table) {
            $table->dropForeign('pengeluaran_operasionals_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
