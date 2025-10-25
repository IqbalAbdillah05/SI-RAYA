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
        Schema::table('presensi_mahasiswa', function (Blueprint $table) {
            // Tambahkan mata_kuliah_id jika belum ada
            if (!Schema::hasColumn('presensi_mahasiswa', 'mata_kuliah_id')) {
                $table->foreignId('mata_kuliah_id')
                      ->nullable()
                      ->constrained('mata_kuliah')
                      ->cascadeOnDelete();
            }

            // Tambahkan prodi_id jika belum ada
            if (!Schema::hasColumn('presensi_mahasiswa', 'prodi_id')) {
                $table->foreignId('prodi_id')
                      ->nullable()
                      ->constrained('prodi')
                      ->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensi_mahasiswa', function (Blueprint $table) {
            // Hapus foreign key jika ada
            if (Schema::hasColumn('presensi_mahasiswa', 'mata_kuliah_id')) {
                $table->dropForeignIdFor('mata_kuliah_id');
            }

            if (Schema::hasColumn('presensi_mahasiswa', 'prodi_id')) {
                $table->dropForeignIdFor('prodi_id');
            }
        });
    }
};
