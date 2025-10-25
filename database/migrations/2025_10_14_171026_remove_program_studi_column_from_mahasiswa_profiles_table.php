<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProgramStudiColumnFromMahasiswaProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mahasiswa_profiles', function (Blueprint $table) {
            // Hapus kolom program_studi
            $table->dropColumn('program_studi');
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
            // Tambahkan kembali kolom program_studi jika perlu
            $table->string('program_studi', 100)->nullable()->after('nim');
        });
    }
}
