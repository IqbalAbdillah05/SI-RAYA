<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('presensi_dosen', function (Blueprint $table) {
            $table->string('keterangan', 255)->nullable()->after('jarak_masuk');
        });
    }

    public function down()
    {
        Schema::table('presensi_dosen', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
};