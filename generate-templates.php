<?php

require __DIR__.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Template Mahasiswa
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Mahasiswa');

// Header
$headers = [
    'A1' => 'nama_lengkap',
    'B1' => 'nim',
    'C1' => 'nik',
    'D1' => 'email',
    'E1' => 'prodi',
    'F1' => 'semester',
    'G1' => 'jenis_kelamin',
    'H1' => 'tempat_lahir',
    'I1' => 'tanggal_lahir',
    'J1' => 'tanggal_masuk',
    'K1' => 'agama',
    'L1' => 'alamat',
    'M1' => 'no_telp',
    'N1' => 'biaya_masuk',
    'O1' => 'status_mahasiswa',
    'P1' => 'status_sync',
    'Q1' => 'password',
];

foreach ($headers as $cell => $value) {
    $sheet->setCellValue($cell, $value);
}

// Style header
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4472C4'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];

$sheet->getStyle('A1:Q1')->applyFromArray($headerStyle);

// Auto width
foreach (range('A', 'Q') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Contoh data
$sheet->setCellValue('A2', 'Ahmad Fauzi');
$sheet->setCellValue('B2', '24114001001');
$sheet->setCellValue('C2', '3509040801060001'); // NIK 16 digit
$sheet->setCellValue('D2', 'ahmad.fauzi@example.com');
$sheet->setCellValue('E2', 'Pendidikan Bahasa Arab'); // Nama Prodi (bukan ID)
$sheet->setCellValue('F2', '1');
$sheet->setCellValue('G2', 'Laki-laki');
$sheet->setCellValue('H2', 'Jakarta');
$sheet->setCellValue('I2', '2005-01-01'); // Format: YYYY-MM-DD
$sheet->setCellValue('J2', '2024-09-01'); // Format: YYYY-MM-DD
$sheet->setCellValue('K2', 'Islam');
$sheet->setCellValue('L2', 'Jl. Contoh No. 123');
$sheet->setCellValue('M2', '081234567890');
$sheet->setCellValue('N2', '1500000');
$sheet->setCellValue('O2', 'Aktif'); // Aktif atau Tidak Aktif
$sheet->setCellValue('P2', 'Belum Sync'); // Sudah Sync atau Belum Sync
$sheet->setCellValue('Q2', '24114001001'); // Default password = NIM

// Keterangan
$sheet->setCellValue('A4', 'KETERANGAN:');
$sheet->setCellValue('A5', '- Kolom yang wajib diisi: nama_lengkap, nim, email, prodi');
$sheet->setCellValue('A6', '- nik: 16 digit (opsional)');
$sheet->setCellValue('A7', '- prodi: Tulis NAMA PRODI lengkap (contoh: Pendidikan Bahasa Arab, Pendidikan Bahasa Inggris)');
$sheet->setCellValue('A8', '- semester: 1-14');
$sheet->setCellValue('A9', '- jenis_kelamin: Laki-laki atau Perempuan');
$sheet->setCellValue('A10', '- Format tanggal: YYYY-MM-DD (contoh: 2005-01-01)');
$sheet->setCellValue('A11', '- status_mahasiswa: Aktif atau Tidak Aktif');
$sheet->setCellValue('A12', '- status_sync: Sudah Sync atau Belum Sync');
$sheet->setCellValue('A13', '- password: Jika kosong, default menggunakan NIM');
$sheet->setCellValue('A14', '- Baris 2 adalah contoh data, silakan hapus atau ganti dengan data sebenarnya');
$sheet->setCellValue('A15', '- PENTING: Nama prodi harus sesuai dengan yang ada di database (tidak case sensitive)');

$sheet->getStyle('A4')->getFont()->setBold(true);

// Save
$writer = new Xlsx($spreadsheet);
$writer->save(__DIR__.'/public/templates/template_mahasiswa.xlsx');

echo "Template Mahasiswa berhasil dibuat!\n";

// Template Dosen
$spreadsheet2 = new Spreadsheet();
$sheet2 = $spreadsheet2->getActiveSheet();
$sheet2->setTitle('Data Dosen');

// Header
$headers2 = [
    'A1' => 'nama_lengkap',
    'B1' => 'nidn',
    'C1' => 'email',
    'D1' => 'prodi',
    'E1' => 'jenis_kelamin',
    'F1' => 'tempat_lahir',
    'G1' => 'tanggal_lahir',
    'H1' => 'agama',
    'I1' => 'alamat',
    'J1' => 'no_telp',
    'K1' => 'password',
];

foreach ($headers2 as $cell => $value) {
    $sheet2->setCellValue($cell, $value);
}

// Style header
$sheet2->getStyle('A1:K1')->applyFromArray($headerStyle);

// Auto width
foreach (range('A', 'K') as $col) {
    $sheet2->getColumnDimension($col)->setAutoSize(true);
}

// Contoh data
$sheet2->setCellValue('A2', 'Dr. Budi Santoso, M.Pd');
$sheet2->setCellValue('B2', '0123456789');
$sheet2->setCellValue('C2', 'budi.santoso@example.com');
$sheet2->setCellValue('D2', 'Pendidikan Bahasa Arab'); // Nama Prodi (bebas, tidak harus sesuai database)
$sheet2->setCellValue('E2', 'Laki-laki');
$sheet2->setCellValue('F2', 'Surabaya');
$sheet2->setCellValue('G2', '1980-02-15'); // Format: YYYY-MM-DD
$sheet2->setCellValue('H2', 'Islam');
$sheet2->setCellValue('I2', 'Jl. Dosen No. 456');
$sheet2->setCellValue('J2', '081234567891');
$sheet2->setCellValue('K2', '0123456789'); // Default password = NIDN

// Keterangan
$sheet2->setCellValue('A4', 'KETERANGAN:');
$sheet2->setCellValue('A5', '- Kolom yang wajib diisi: nama_lengkap, nidn, email');
$sheet2->setCellValue('A6', '- prodi: BEBAS, tidak harus sesuai database. Bisa tulis apa saja (contoh: Bahasa Arab, Matematika)');
$sheet2->setCellValue('A7', '- jenis_kelamin: Laki-laki atau Perempuan');
$sheet2->setCellValue('A8', '- Format tanggal: YYYY-MM-DD (contoh: 1980-02-15)');
$sheet2->setCellValue('A9', '- password: Jika kosong, default menggunakan NIDN');
$sheet2->setCellValue('A10', '- Baris 2 adalah contoh data, silakan hapus atau ganti dengan data sebenarnya');

$sheet2->getStyle('A4')->getFont()->setBold(true);

// Save
$writer2 = new Xlsx($spreadsheet2);
$writer2->save(__DIR__.'/public/templates/template_dosen.xlsx');

echo "Template Dosen berhasil dibuat!\n";
echo "\nFile template tersimpan di:\n";
echo "- public/templates/template_mahasiswa.xlsx\n";
echo "- public/templates/template_dosen.xlsx\n";
