<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('presensi_dosen', function (Blueprint $table) {
            $table->string('foto_bukti')->nullable();
        });
    }

    public function down()
    {
        Schema::table('presensi_dosen', function (Blueprint $table) {
            $table->dropColumn('foto_bukti');
        });
    }
};