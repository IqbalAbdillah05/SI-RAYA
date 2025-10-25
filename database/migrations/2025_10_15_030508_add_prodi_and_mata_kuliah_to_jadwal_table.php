<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Hapus kolom mata_kuliah string
            $table->dropColumn('mata_kuliah');
            $table->dropColumn('program_studi');

            // Tambahkan foreign key mata_kuliah_id dan prodi_id
            $table->foreignId('mata_kuliah_id')
                  ->nullable()
                  ->constrained('mata_kuliah')
                  ->cascadeOnDelete();
            
            $table->foreignId('prodi_id')
                  ->nullable()
                  ->constrained('prodi')
                  ->cascadeOnDelete();
        });

        // Update existing records
        $defaultMataKuliah = DB::table('mata_kuliah')->first();
        $defaultProdi = DB::table('prodi')->first();

        if ($defaultMataKuliah && $defaultProdi) {
            DB::table('jadwal')
                ->update([
                    'mata_kuliah_id' => $defaultMataKuliah->id,
                    'prodi_id' => $defaultProdi->id
                ]);
        }
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Hapus foreign key
            $table->dropForeignIdFor('mata_kuliah_id');
            $table->dropForeignIdFor('prodi_id');

            // Tambahkan kembali kolom string
            $table->string('mata_kuliah', 150)->nullable();
            $table->string('program_studi', 100)->nullable();
        });
    }
};
