<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToMahasiswaProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mahasiswa_profiles', function (Blueprint $table) {
            // Tambahkan foreign key ke prodi
            $table->foreign('prodi_id')
                  ->references('id')
                  ->on('prodi')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswa_profiles', function (Blueprint $table) {
            // Hapus foreign key
            $table->dropForeign(['prodi_id']);
        });
    }
}
