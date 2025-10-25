<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('mata_kuliah', 150);
            $table->foreignId('dosen_id')->constrained('dosen_profiles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('program_studi', 100)->nullable();
            $table->string('ruang', 50)->nullable();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('semester', 10);
            $table->string('tahun_ajaran', 20);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
};
