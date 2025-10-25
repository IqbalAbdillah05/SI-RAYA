<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Mahasiswa;

echo "=== TEST KRS FILTER ===\n\n";

// Test 1: Mahasiswa dengan KRS mata kuliah 9
echo "Test 1: Filter mahasiswa prodi 10, semester 1, mata kuliah 9\n";
$mahasiswa = Mahasiswa::where('prodi_id', 10)
    ->where('status_mahasiswa', 'Aktif')
    ->whereHas('krs', function($query) {
        $query->where('semester', 1)
              ->where('status_validasi', 'Disetujui')
              ->whereHas('krsDetail', function($subQuery) {
                  $subQuery->where('mata_kuliah_id', 9);
              });
    })
    ->get();

echo "Jumlah mahasiswa: " . $mahasiswa->count() . "\n";
foreach ($mahasiswa as $m) {
    echo "  - {$m->nama_lengkap} (ID: {$m->id})\n";
}

echo "\n";

// Test 2: Mahasiswa dengan KRS mata kuliah 11
echo "Test 2: Filter mahasiswa prodi 10, semester 1, mata kuliah 11\n";
$mahasiswa2 = Mahasiswa::where('prodi_id', 10)
    ->where('status_mahasiswa', 'Aktif')
    ->whereHas('krs', function($query) {
        $query->where('semester', 1)
              ->where('status_validasi', 'Disetujui')
              ->whereHas('krsDetail', function($subQuery) {
                  $subQuery->where('mata_kuliah_id', 11);
              });
    })
    ->get();

echo "Jumlah mahasiswa: " . $mahasiswa2->count() . "\n";
foreach ($mahasiswa2 as $m) {
    echo "  - {$m->nama_lengkap} (ID: {$m->id})\n";
}

echo "\n";

// Test 3: Mahasiswa TANPA filter KRS (semua mahasiswa aktif prodi 10)
echo "Test 3: Semua mahasiswa aktif prodi 10 (tanpa filter KRS)\n";
$allMahasiswa = Mahasiswa::where('prodi_id', 10)
    ->where('status_mahasiswa', 'Aktif')
    ->get();

echo "Jumlah mahasiswa: " . $allMahasiswa->count() . "\n";
foreach ($allMahasiswa as $m) {
    echo "  - {$m->nama_lengkap} (ID: {$m->id})\n";
}
