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
        Schema::table('presensi_dosen', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['lokasi_id']);
            
            // Make lokasi_id nullable
            $table->foreignId('lokasi_id')->nullable()->change()->constrained('lokasi_presensi')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensi_dosen', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['lokasi_id']);
            
            // Make lokasi_id not nullable again
            $table->foreignId('lokasi_id')->nullable(false)->change()->constrained('lokasi_presensi')->cascadeOnDelete();
        });
    }
};
