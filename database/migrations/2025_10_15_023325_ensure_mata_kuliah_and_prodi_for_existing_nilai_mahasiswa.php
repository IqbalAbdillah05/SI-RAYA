<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Ambil mata kuliah default
        $defaultMataKuliah = DB::table('mata_kuliah')->first();
        
        // Ambil prodi default
        $defaultProdi = DB::table('prodi')->first();

        if ($defaultMataKuliah && $defaultProdi) {
            // Update nilai mahasiswa yang mata kuliah atau prodi-nya null
            DB::table('nilai_mahasiswa')
                ->whereNull('mata_kuliah_id')
                ->orWhereNull('prodi_id')
                ->update([
                    'mata_kuliah_id' => $defaultMataKuliah->id,
                    'prodi_id' => $defaultProdi->id
                ]);
        }
    }

    public function down()
    {
        // Tidak perlu melakukan apa-apa pada rollback
    }
};
