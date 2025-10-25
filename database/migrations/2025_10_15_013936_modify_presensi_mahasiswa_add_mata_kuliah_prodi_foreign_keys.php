<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('presensi_mahasiswa', function (Blueprint $table) {
            // Hapus kolom mata_kuliah string
            $table->dropColumn('mata_kuliah');
            
            // Tambahkan foreign key untuk mata kuliah
            $table->foreignId('mata_kuliah_id')
                  ->constrained('mata_kuliah')
                  ->cascadeOnDelete();
            
            // Tambahkan foreign key untuk prodi
            $table->foreignId('prodi_id')
                  ->constrained('prodi')
                  ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('presensi_mahasiswa', function (Blueprint $table) {
            // Kembalikan kolom mata_kuliah
            $table->string('mata_kuliah', 100);
            
            // Hapus foreign key
            $table->dropForeignIdFor('mata_kuliah_id');
            $table->dropForeignIdFor('prodi_id');
        });
    }
};
