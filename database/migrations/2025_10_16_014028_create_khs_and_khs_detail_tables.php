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
        Schema::create('khs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('prodi_id');
            $table->integer('semester');
            $table->string('tahun_ajaran', 25);
            $table->integer('total_sks')->default(0);
            $table->decimal('ips', 4, 2)->default(0.00);
            $table->decimal('ipk', 4, 2)->default(0.00);
            $table->enum('status_validasi', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamps();

            // Foreign keys
            $table->foreign('mahasiswa_id')
                  ->references('id')
                  ->on('mahasiswa_profiles')
                  ->onDelete('cascade');

            $table->foreign('prodi_id')
                  ->references('id')
                  ->on('prodi')
                  ->onDelete('cascade');
        });

        Schema::create('khs_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('khs_id');
            $table->unsignedBigInteger('mata_kuliah_id');
            $table->unsignedBigInteger('nilai_mahasiswa_id')->nullable(); // Tambahkan kolom ini
            $table->decimal('nilai_angka', 5, 2)->default(0.00);
            $table->char('nilai_huruf', 2)->nullable();
            $table->decimal('nilai_indeks', 4, 2)->default(0.00);
            $table->integer('sks')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('khs_id')
                  ->references('id')
                  ->on('khs')
                  ->onDelete('cascade');

            $table->foreign('mata_kuliah_id')
                  ->references('id')
                  ->on('mata_kuliah')
                  ->onDelete('cascade');

            // Foreign key untuk nilai mahasiswa
            $table->foreign('nilai_mahasiswa_id')
                  ->references('id')
                  ->on('nilai_mahasiswa')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khs_detail');
        Schema::dropIfExists('khs');
    }
};
