<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Mahasiswa;
use App\Models\PresensiMahasiswa;

echo "=== TEST KRS FILTER PRESENSI MAHASISWA ===\n\n";

$prodiId = 10;
$semester = 1;
$matakuliahId = 9;

// Test 1: Mahasiswa dengan KRS mata kuliah 9
echo "Test 1: Filter mahasiswa untuk presensi\n";
echo "Prodi: $prodiId, Semester: $semester, Mata Kuliah: $matakuliahId\n\n";

$mahasiswa = Mahasiswa::with('prodi')
    ->where('prodi_id', $prodiId)
    ->where('status_mahasiswa', 'aktif')
    ->whereHas('krs', function($query) use ($semester, $matakuliahId) {
        $query->where('semester', $semester)
              ->where('status_validasi', 'Disetujui')
              ->whereHas('krsDetail', function($subQuery) use ($matakuliahId) {
                  $subQuery->where('mata_kuliah_id', $matakuliahId);
              });
    })
    ->orderBy('nim')
    ->get(['id', 'nim', 'nama_lengkap', 'prodi_id', 'semester']);

echo "Jumlah mahasiswa yang bisa dipresensi: " . $mahasiswa->count() . "\n";
foreach ($mahasiswa as $m) {
    echo "  - {$m->nim} - {$m->nama_lengkap}\n";
}

echo "\n";

// Test 2: Semua mahasiswa tanpa filter KRS
echo "Test 2: Semua mahasiswa aktif prodi $prodiId (TANPA filter KRS)\n";
$allMahasiswa = Mahasiswa::where('prodi_id', $prodiId)
    ->where('status_mahasiswa', 'aktif')
    ->orderBy('nim')
    ->get(['id', 'nim', 'nama_lengkap']);

echo "Jumlah total mahasiswa: " . $allMahasiswa->count() . "\n";
foreach ($allMahasiswa as $m) {
    echo "  - {$m->nim} - {$m->nama_lengkap}\n";
}

echo "\n=== KESIMPULAN ===\n";
echo "Dengan filter KRS, hanya mahasiswa yang terdaftar di KRS untuk mata kuliah tersebut yang akan muncul.\n";
echo "Ini memastikan dosen hanya bisa mempresensi mahasiswa yang resmi mengambil mata kuliah tersebut.\n";
