<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseMataKuliahKodeLengthTo20Final extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mata_kuliah', function (Blueprint $table) {
            $table->string('kode_matakuliah', 20)->change();
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
            $table->string('kode_matakuliah', 10)->change();
        });
    }
}
