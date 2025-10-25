<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJsAndJenisMkToMataKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mata_kuliah', function (Blueprint $table) {
            // Tambahkan kolom js (integer)
            if (!Schema::hasColumn('mata_kuliah', 'js')) {
                $table->integer('js')->nullable()->comment('Jumlah SKS (Satuan Kredit Semester)');
            }

            // Tambahkan kolom jenis_mk (enum)
            if (!Schema::hasColumn('mata_kuliah', 'jenis_mk')) {
                $table->enum('jenis_mk', ['wajib', 'pilihan'])->default('wajib')
                    ->comment('Jenis Mata Kuliah: Wajib atau Pilihan');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mata_kuliah', function (Blueprint $table) {
            // Hapus kolom js jika ada
            if (Schema::hasColumn('mata_kuliah', 'js')) {
                $table->dropColumn('js');
            }

            // Hapus kolom jenis_mk jika ada
            if (Schema::hasColumn('mata_kuliah', 'jenis_mk')) {
                $table->dropColumn('jenis_mk');
            }
        });
    }
}
