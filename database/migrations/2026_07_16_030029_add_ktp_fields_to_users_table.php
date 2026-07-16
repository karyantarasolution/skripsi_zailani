<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->after('nip');
            $table->string('tempat_lahir')->nullable()->after('nik');
            $table->string('agama')->nullable()->after('tempat_lahir');
            $table->string('status_kawin')->nullable()->after('agama');
            $table->string('rt_rw')->nullable()->after('alamat');
            $table->string('kelurahan')->nullable()->after('rt_rw');
            $table->string('kecamatan')->nullable()->after('kelurahan');
            $table->string('kabupaten')->nullable()->after('kecamatan');
            $table->string('provinsi')->nullable()->after('kabupaten');
            $table->string('kode_pos', 10)->nullable()->after('provinsi');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'tempat_lahir', 'agama', 'status_kawin',
                'rt_rw', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos',
            ]);
        });
    }
};
