<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Ambil dosen pertama yang valid
        $defaultDosen = DB::table('dosen_profiles')->first();

        if ($defaultDosen) {
            // Update presensi mahasiswa yang dosen_id-nya tidak valid
            DB::table('presensi_mahasiswa')
                ->whereNotExists(function($query) {
                    $query->select(DB::raw(1))
                          ->from('dosen_profiles')
                          ->whereRaw('dosen_profiles.id = presensi_mahasiswa.dosen_id');
                })
                ->update([
                    'dosen_id' => $defaultDosen->id
                ]);
        }
    }

    public function down()
    {
        // Tidak perlu melakukan apa-apa pada rollback
    }
};
