<?php
/**
 * Generate Template Mata Kuliah SAJA
 * Jalankan: php generate_template_mata_kuliah.php
 */

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

echo "=== GENERATING TEMPLATE MATA KULIAH ===\n\n";

// Create templates directory if not exists
$templatesDir = __DIR__ . '/public/templates';
if (!file_exists($templatesDir)) {
    mkdir($templatesDir, 0755, true);
    echo "✓ Created templates directory\n";
}

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();

// Sheet 1: Data Mata Kuliah
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Mata Kuliah');

// Set column headers
$headers = [
    'kode_matakuliah',
    'nama_matakuliah',
    'prodi',
    'sks',
    'jenis_mk',
    'semester',
    'js'
];

// Write headers
$column = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($column . '1', $header);
    $column++;
}

// Add example data (row 2)
$exampleData = [
    'MK001',                    // kode_matakuliah
    'Pengantar Ilmu Komputer',  // nama_matakuliah
    'Teknik Informatika',       // prodi (nama prodi, bukan ID)
    '3',                        // sks
    'wajib',                    // jenis_mk
    '1',                        // semester
    '2'                         // js (jam simulasi)
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

$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

// Auto size columns
foreach (range('A', 'G') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Set row height for header
$sheet->getRowDimension(1)->setRowHeight(25);

// Add instructions in a comment/note
$sheet->getComment('A1')->getText()->createTextRun(
    "PETUNJUK PENGISIAN:\n" .
    "1. Jangan ubah header di baris 1\n" .
    "2. Isi data mulai dari baris 2\n" .
    "3. Prodi isi dengan nama prodi (contoh: Teknik Informatika)\n" .
    "4. SKS: 1-6\n" .
    "5. Jenis MK: wajib, pilihan, atau tugas akhir\n" .
    "6. Semester: 1-8\n" .
    "7. JS (Jam Simulasi): 1-6 atau kosongkan"
);

// ============================================
// Sheet 2: PETUNJUK PENGISIAN
// ============================================
$instructionSheet = $spreadsheet->createSheet();
$instructionSheet->setTitle('PETUNJUK');

// Header instruction sheet
$instructionSheet->setCellValue('A1', 'PETUNJUK PENGISIAN DATA MATA KULIAH');
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
    ['1', 'kode_matakuliah', 'Kode Mata Kuliah (unique)', 'MK001'],
    ['2', 'nama_matakuliah', 'Nama lengkap mata kuliah', 'Pengantar Ilmu Komputer'],
    ['3', 'prodi', 'Nama Program Studi (bukan ID)', 'Teknik Informatika'],
    ['4', 'sks', 'Jumlah SKS (1-6)', '3'],
    ['5', 'jenis_mk', 'Jenis Mata Kuliah', 'wajib/pilihan/tugas akhir'],
    ['6', 'semester', 'Semester (1-8)', '1'],
    ['7', 'js', 'Jam Simulasi (1-6, opsional)', '2']
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
$instructionSheet->setCellValue('A' . $noteRow, '• Jangan mengubah header di baris 1 pada sheet "Data Mata Kuliah"');
$instructionSheet->mergeCells('A' . $noteRow . ':D' . $noteRow);

$noteRow++;
$instructionSheet->setCellValue('A' . $noteRow, '• Isi data mulai dari baris 2');
$instructionSheet->mergeCells('A' . $noteRow . ':D' . $noteRow);

$noteRow++;
$instructionSheet->setCellValue('A' . $noteRow, '• Kode Mata Kuliah harus unique (tidak boleh duplikat)');
$instructionSheet->mergeCells('A' . $noteRow . ':D' . $noteRow);

$noteRow++;
$instructionSheet->setCellValue('A' . $noteRow, '• Pastikan nama Prodi sesuai dengan data di database');
$instructionSheet->mergeCells('A' . $noteRow . ':D' . $noteRow);

// Set active sheet back to data sheet
$spreadsheet->setActiveSheetIndex(0);

// Save file
$writer = new Xlsx($spreadsheet);
$filePath = $templatesDir . '/template_mata_kuliah.xlsx';

try {
    $writer->save($filePath);
    
    echo "✓ Template mata kuliah berhasil dibuat!\n";
    echo "  Location: {$filePath}\n";
    echo "  Size: " . number_format(filesize($filePath)) . " bytes\n";
    echo "  Readable: " . (is_readable($filePath) ? 'Yes' : 'No') . "\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n=== DONE ===\n";