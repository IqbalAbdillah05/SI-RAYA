<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Prodi;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data lama
        DB::table('users')->delete();
        DB::table('dosen_profiles')->delete();
        DB::table('mahasiswa_profiles')->delete();

        // Pastikan prodi ada
        $this->ensureProdiExists();

        // Seed Admin only
        $admin = User::create([
            'name' => 'Admin SI-RAYA',
            'email' => 'admin@stairaya.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'nidn' => null,
            'nim' => null,
        ]);

        // Aktifkan kembali pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Memastikan prodi ada, jika tidak ada maka buat
     */
    private function ensureProdiExists()
    {
        $prodis = [
            ['kode_prodi' => 'TI-S1', 'nama_prodi' => 'Teknik Informatika', 'jenjang' => 'S1'],
            ['kode_prodi' => 'SI-S1', 'nama_prodi' => 'Sistem Informasi', 'jenjang' => 'S1'],
            ['kode_prodi' => 'MI-D3', 'nama_prodi' => 'Manajemen Informatika', 'jenjang' => 'D3'],
            ['kode_prodi' => 'KA-D4', 'nama_prodi' => 'Komputerisasi Akuntansi', 'jenjang' => 'D4']
        ];

        foreach ($prodis as $prodi) {
            Prodi::firstOrCreate(
                ['kode_prodi' => $prodi['kode_prodi']],
                [
                    'nama_prodi' => $prodi['nama_prodi'],
                    'jenjang' => $prodi['jenjang']
                ]
            );
        }
    }

    /**
     * Membuat prodi baru jika tidak ada
     */
    private function createProdi($kodeProdi, $namaProdi, $jenjang)
    {
        $prodi = Prodi::firstOrCreate(
            ['kode_prodi' => $kodeProdi],
            [
                'nama_prodi' => $namaProdi,
                'jenjang' => $jenjang
            ]
        );

        return $prodi->id;
    }
}
