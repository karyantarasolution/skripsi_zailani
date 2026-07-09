<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengeluaran_operasionals', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->text('deskripsi')->nullable();
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal');
            $table->string('bukti')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_operasionals');
    }
};
