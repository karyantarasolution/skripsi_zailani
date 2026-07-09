<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change ENUM to VARCHAR first to avoid truncation errors
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(20) NOT NULL DEFAULT 'pelanggan'");

        // Migrate old role values to new ones
        DB::statement("UPDATE users SET role = 'admin' WHERE role IN ('super_admin', 'admin_kantor', 'kasir')");

        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->unique()->after('id');
            $table->string('jabatan')->nullable()->after('role');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('jabatan');
            $table->date('tanggal_lahir')->nullable()->after('jenis_kelamin');
            $table->string('foto')->nullable()->after('tanggal_lahir');
            $table->integer('poin')->default(0)->after('foto');
            $table->date('tanggal_bergabung')->nullable()->after('poin');
            $table->string('username')->nullable()->unique()->after('name');
        });

        // Now set the ENUM with new values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'pegawai', 'pelanggan') NOT NULL DEFAULT 'pelanggan'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(20) NOT NULL DEFAULT 'pelanggan'");
        DB::statement("UPDATE users SET role = 'pelanggan' WHERE role NOT IN ('super_admin', 'admin_kantor', 'kasir', 'pelanggan')");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nip', 'jabatan', 'jenis_kelamin', 'tanggal_lahir', 'foto', 'poin', 'tanggal_bergabung', 'username']);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin_kantor', 'kasir', 'pelanggan') NOT NULL DEFAULT 'pelanggan'");
    }
};
