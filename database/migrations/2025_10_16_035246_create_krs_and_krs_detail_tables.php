<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKrsAndKrsDetailTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->integer('semester')->nullable();
            $table->string('tahun_ajaran', 9)->nullable();
            $table->date('tanggal_pengisian')->nullable();
            $table->enum('status_validasi', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('mahasiswa_id')
                  ->references('id')
                  ->on('mahasiswa_profiles')
                  ->onDelete('cascade');
        });

        Schema::create('krs_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('krs_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('krs_id')
                  ->references('id')
                  ->on('krs')
                  ->onDelete('cascade');
            
            $table->foreign('jadwal_id')
                  ->references('id')
                  ->on('jadwal')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('krs_detail');
        Schema::dropIfExists('krs');
    }
}
