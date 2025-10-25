<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('presensi_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('tanggal');
            $table->timestamp('waktu_presensi')->useCurrent()->after('mata_kuliah');
        });
    }

    public function down()
    {
        Schema::table('presensi_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('waktu_presensi');
            $table->date('tanggal')->after('mata_kuliah');
        });
    }
};