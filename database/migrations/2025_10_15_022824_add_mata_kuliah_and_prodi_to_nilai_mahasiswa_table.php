<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nilai_mahasiswa', function (Blueprint $table) {
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

        // Update existing records
        $mataKuliah = DB::table('mata_kuliah')->first();
        $prodi = DB::table('prodi')->first();

        if ($mataKuliah && $prodi) {
            DB::table('nilai_mahasiswa')
                ->update([
                    'mata_kuliah_id' => $mataKuliah->id,
                    'prodi_id' => $prodi->id
                ]);
        }
    }

    public function down()
    {
        Schema::table('nilai_mahasiswa', function (Blueprint $table) {
            // Tambahkan kembali kolom mata_kuliah
            $table->string('mata_kuliah', 150);
            
            // Hapus foreign key
            $table->dropForeignIdFor('mata_kuliah_id');
            $table->dropForeignIdFor('prodi_id');
        });
    }
};
