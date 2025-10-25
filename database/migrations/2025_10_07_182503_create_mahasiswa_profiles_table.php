<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nama_lengkap', 150);
            $table->string('nim', 50)->index();
            $table->string('nik', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('program_studi', 100)->nullable();
            
            // Tambahkan kolom prodi_id tanpa foreign key
            $table->unsignedBigInteger('prodi_id')->nullable();

            // Ubah tipe semester menjadi integer
            $table->integer('semester')->nullable();

            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->string('agama', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->string('pas_foto', 255)->nullable();
            $table->decimal('biaya_masuk', 15, 2)->nullable();
            $table->enum('status_mahasiswa', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->enum('status_sync', ['Sudah Sync', 'Belum Sync'])->default('Belum Sync');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa_profiles');
    }
};
