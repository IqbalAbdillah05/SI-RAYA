<?php

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();

// Sheet 1: Data Mahasiswa
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Mahasiswa');

// Set column headers
$headers = [
    'nama_lengkap',
    'nim',
    'nik',
    'email',
    'prodi',
    'semester',
    'jenis_kelamin',
    'tempat_lahir',
    'tanggal_lahir',
    'tanggal_masuk',
    'agama',
    'alamat',
    'no_telp',
    'pas_foto',
    'biaya_masuk',
    'status_mahasiswa',
    'status_sync'
];

// Write headers
$column = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($column . '1', $header);
    $column++;
}

// Add example data (row 2)
$exampleData = [
    'Ahmad Rizki',                    // nama_lengkap
    '2024010001',                     // nim
    '3509040801060001',               // nik (16 digit)
    'ahmad.rizki@example.com',        // email
    'Pendidikan Bahasa Arab',         // prodi (nama prodi, bukan ID)
    '1',                              // semester (1-14)
    'Laki-laki',                      // jenis_kelamin
    'Surabaya',                       // tempat_lahir
    '19/05/2005',                     // tanggal_lahir (DD/MM/YYYY)
    '01/09/2024',                     // tanggal_masuk (DD/MM/YYYY)
    'Islam',                          // agama
    'Jl. Merdeka No. 123, Surabaya',  // alamat
    '081234567890',                   // no_telp
    '',                               // pas_foto (kosongkan)
    '5000000',                        // biaya_masuk
    'Aktif',                          // status_mahasiswa (Aktif/Tidak Aktif)
    'Belum Sync'                      // status_sync (Sudah Sync/Belum Sync)
];

$column = 'A';
foreach ($exampleData as $data) {
    $sheet->setCellValue($column . '2', $data);
    $column++;
}

// Style the header row
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF']
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4472C4']
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000']
        ]
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER
    ]
];

$sheet->getStyle('A1:Q1')->applyFromArray($headerStyle);

// Format kolom NIK (kolom C) dan no_telp (kolom M) sebagai TEXT
$sheet->getStyle('C:C')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
$sheet->getStyle('M:M')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

// Format kolom NIM (kolom B) sebagai TEXT juga untuk keamanan
$sheet->getStyle('B:B')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

// Auto size columns
foreach (range('A', 'Q') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Set row height for header
$sheet->getRowDimension(1)->setRowHeight(25);

// Add instructions in a comment/note
$sheet->getComment('A1')->getText()->createTextRun(
    "PETUNJUK PENGISIAN:\n" .
    "1. Jangan ubah header di baris 1\n" .
    "2. Isi data mulai dari baris 2\n" .
    "3. NIK harus 16 digit lengkap (sudah diformat sebagai TEXT)\n" .
    "4. No Telp tulis lengkap dengan 0 di depan (sudah diformat sebagai TEXT)\n" .
    "5. Prodi isi dengan nama prodi (contoh: Pendidikan Bahasa Arab)\n" .
    "6. Semester: 1-14\n" .
    "7. Tanggal format: DD/MM/YYYY (contoh: 19/05/2005)\n" .
    "8. Status Mahasiswa: Aktif atau Tidak Aktif\n" .
    "9. Status Sync: Sudah Sync atau Belum Sync"
);

// ============================================
// Sheet 2: PETUNJUK PENGISIAN
// ============================================
$instructionSheet = $spreadsheet->createSheet();
$instructionSheet->setTitle('PETUNJUK');

// Header instruction sheet
$instructionSheet->setCellValue('A1', 'PETUNJUK PENGISIAN DATA MAHASISWA');
$instructionSheet->mergeCells('A1:D1');
$instructionSheet->getStyle('A1')->applyFromArray([
    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
]);
$instructionSheet->getRowDimension(1)->setRowHeight(30);

// Instructions content
$instructions = [
    ['No', 'Kolom', 'Keterangan', 'Contoh'],
    ['1', 'nama_lengkap', 'Nama lengkap mahasiswa', 'Ahmad Rizki'],
    ['2', 'nim', 'Nomor Induk Mahasiswa (unique)', '2024010001'],
    ['3', 'nik', 'NIK 16 digit (format TEXT)', '3509040801060001'],
    ['4', 'email', 'Email mahasiswa (unique)', 'ahmad.rizki@example.com'],
    ['5', 'prodi', 'Nama Program Studi (bukan ID)', 'Pendidikan Bahasa Arab'],
    ['6', 'semester', 'Semester aktif (1-14)', '1'],
    ['7', 'jenis_kelamin', 'Laki-laki atau Perempuan', 'Laki-laki'],
    ['8', 'tempat_lahir', 'Tempat lahir', 'Surabaya'],
    ['9', 'tanggal_lahir', 'Format: DD/MM/YYYY', '19/05/2005'],
    ['10', 'tanggal_masuk', 'Format: DD/MM/YYYY', '01/09/2024'],
    ['11', 'agama', 'Agama', 'Islam'],
    ['12', 'alamat', 'Alamat lengkap', 'Jl. Merdeka No. 123'],
    ['13', 'no_telp', 'Nomor telpon dengan 0 di depan', '081234567890'],
    ['14', 'pas_foto', 'Kosongkan (opsional)', ''],
    ['15', 'biaya_masuk', 'Biaya pendaftaran (angka)', '5000000'],
    ['16', 'status_mahasiswa', 'Aktif atau Tidak Aktif', 'Aktif'],
    ['17', 'status_sync', 'Sudah Sync atau Belum Sync', 'Belum Sync'],
];

$row = 3;
foreach ($instructions as $instruction) {
    $col = 'A';
    foreach ($instruction as $value) {
        $instructionSheet->setCellValue($col . $row, $value);
        $col++;
    }
    $row++;
}

// Style instruction table
$instructionSheet->getStyle('A3:D3')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '70AD47']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
]);

$instructionSheet->getStyle('A4:D' . ($row - 1))->applyFromArray([
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
]);

// Auto size columns in instruction sheet
foreach (range('A', 'D') as $col) {
    $instructionSheet->getColumnDimension($col)->setAutoSize(true);
}

// Add important notes
$noteRow = $row + 1;
$instructionSheet->setCellValue('A' . $noteRow, 'CATATAN PENTING:');
$instructionSheet->getStyle('A' . $noteRow)->getFont()->setBold(true)->setSize(12);
$instructionSheet->mergeCells('A' . $noteRow . ':D' . $noteRow);

$noteRow++;
$instructionSheet->setCellValue('A' . $noteRow, '• Jangan mengubah header di baris 1 pada sheet "Data Mahasiswa"');
$instructionSheet->mergeCells('A' . $noteRow . ':D' . $noteRow);

$noteRow++;
$instructionSheet->setCellValue('A' . $noteRow, '• Isi data mulai dari baris 2');
$instructionSheet->mergeCells('A' . $noteRow . ':D' . $noteRow);

$noteRow++;
$instructionSheet->setCellValue('A' . $noteRow, '• Kolom NIK, NIM, dan no_telp sudah diformat sebagai TEXT untuk menjaga angka 0');
$instructionSheet->mergeCells('A' . $noteRow . ':D' . $noteRow);

$noteRow++;
$instructionSheet->setCellValue('A' . $noteRow, '• NIM dan Email harus unique (tidak boleh duplikat)');
$instructionSheet->mergeCells('A' . $noteRow . ':D' . $noteRow);

$noteRow++;
$instructionSheet->setCellValue('A' . $noteRow, '• Pastikan nama Prodi sesuai dengan data di database');
$instructionSheet->mergeCells('A' . $noteRow . ':D' . $noteRow);

// Set active sheet back to data sheet
$spreadsheet->setActiveSheetIndex(0);

// Save file
$writer = new Xlsx($spreadsheet);
$filePath = __DIR__ . '/public/templates/template_mahasiswa.xlsx';

// Create directory if not exists
if (!file_exists(dirname($filePath))) {
    mkdir(dirname($filePath), 0755, true);
}

$writer->save($filePath);

echo "Template mahasiswa berhasil dibuat di: {$filePath}\n";
echo "Format tanggal sekarang: DD/MM/YYYY (contoh: 19/05/2005)\n";
echo "Kolom NIK, NIM, dan no_telp sudah diformat sebagai TEXT\n";
echo "Angka 0 di depan/belakang akan tetap dipertahankan\n";
