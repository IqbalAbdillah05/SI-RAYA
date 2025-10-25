<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lokasi_presensi', function (Blueprint $table) {
            // Tambahkan kolom alamat
            if (!Schema::hasColumn('lokasi_presensi', 'alamat')) {
                $table->string('alamat', 255)->nullable()->after('nama_lokasi');
            }

            // Tambahkan kolom status
            if (!Schema::hasColumn('lokasi_presensi', 'status')) {
                $table->boolean('status')->default(true)->after('radius');
            }

            // Tambahkan kolom keterangan
            if (!Schema::hasColumn('lokasi_presensi', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lokasi_presensi', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            if (Schema::hasColumn('lokasi_presensi', 'alamat')) {
                $table->dropColumn('alamat');
            }

            if (Schema::hasColumn('lokasi_presensi', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('lokasi_presensi', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }
};
