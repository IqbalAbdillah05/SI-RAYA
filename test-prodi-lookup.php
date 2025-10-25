<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Prodi;

echo "=== TEST PRODI LOOKUP ===\n\n";

// Test 1: Case insensitive search
$testProdi = [
    'Pendidikan Bahasa Arab',
    'pendidikan bahasa arab',
    'PENDIDIKAN BAHASA ARAB',
    'Pendidikan Bahasa Inggris',
];

foreach ($testProdi as $namaProdi) {
    echo "Mencari: '$namaProdi'\n";
    $prodi = Prodi::whereRaw('LOWER(nama_prodi) = ?', [strtolower($namaProdi)])->first();
    
    if ($prodi) {
        echo "  ✓ Ditemukan: ID {$prodi->id} - {$prodi->nama_prodi}\n";
    } else {
        echo "  ✗ Tidak ditemukan\n";
    }
    echo "\n";
}

echo "=== DAFTAR SEMUA PRODI ===\n\n";
$allProdi = Prodi::orderBy('nama_prodi')->get();

echo "Total Prodi: " . $allProdi->count() . "\n\n";
foreach ($allProdi as $p) {
    echo "ID: {$p->id} - {$p->nama_prodi}\n";
}

echo "\n=== KESIMPULAN ===\n";
echo "User tidak perlu menghafalkan ID prodi.\n";
echo "Cukup tulis nama prodi lengkap di Excel, sistem akan mencari otomatis.\n";
echo "Pencarian tidak case sensitive (bisa huruf besar/kecil).\n";
