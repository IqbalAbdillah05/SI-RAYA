<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Ambil semua dosen yang ada di dosen_profiles
        $dosens = DB::table('dosen_profiles')->get();

        foreach ($dosens as $dosen) {
            // Cari atau buat user untuk dosen ini
            $user = DB::table('users')
                ->where('email', $dosen->email)
                ->orWhere('name', $dosen->nama_lengkap)
                ->first();

            if (!$user) {
                // Jika user tidak ditemukan, buat user baru
                $userId = DB::table('users')->insertGetId([
                    'name' => $dosen->nama_lengkap,
                    'email' => $dosen->email,
                    'password' => bcrypt('dosen123'), // Password default
                    'role' => 'dosen',
                    'nidn' => $dosen->nidn,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update dosen_profiles dengan user_id yang baru
                DB::table('dosen_profiles')
                    ->where('id', $dosen->id)
                    ->update(['user_id' => $userId]);
            } else {
                // Update dosen_profiles dengan user_id yang ada
                DB::table('dosen_profiles')
                    ->where('id', $dosen->id)
                    ->update(['user_id' => $user->id]);
            }
        }

        // Update presensi mahasiswa yang dosen_id-nya tidak valid
        $defaultDosen = DB::table('dosen_profiles')->first();

        if ($defaultDosen) {
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
