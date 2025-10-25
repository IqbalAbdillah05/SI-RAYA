<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nilai_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa_profiles')->cascadeOnDelete();
            $table->foreignId('dosen_id')->nullable()->constrained('dosen_profiles')->nullOnDelete();
            $table->string('mata_kuliah', 150);
            $table->decimal('nilai_angka', 5, 2)->nullable();
            $table->string('nilai_huruf', 2)->nullable();
            $table->decimal('nilai_indeks', 3, 2)->nullable();
            $table->string('semester', 10);
            $table->string('tahun_ajaran', 20);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_mahasiswa');
    }
};
