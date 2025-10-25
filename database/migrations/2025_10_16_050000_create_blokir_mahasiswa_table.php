<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blokir_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('prodi_id');
            $table->integer('semester')->nullable();
            $table->string('tahun_ajaran', 9)->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_blokir')->default(now());
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->enum('status_blokir', ['Diblokir', 'Dibuka'])->default('Diblokir');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa_profiles')->onDelete('cascade');
            $table->foreign('prodi_id')->references('id')->on('prodi')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blokir_mahasiswa');
    }
};
