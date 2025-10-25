<?php

namespace App\Exports;

use App\Models\Krs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class KrsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Krs::with(['mahasiswa.prodi', 'details.mataKuliah']);

        // Apply filters from index page
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->whereHas('mahasiswa', function($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', '%' . $search . '%')
                             ->orWhere('nim', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('mahasiswa.prodi', function($subQuery) use ($search) {
                    $subQuery->where('nama_prodi', 'like', '%' . $search . '%');
                })
                ->orWhere('semester', 'like', '%' . $search . '%')
                ->orWhere('tahun_ajaran', 'like', '%' . $search . '%')
                ->orWhere('status_validasi', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Mahasiswa',
            'NIM',
            'Program Studi',
            'Semester',
            'Tahun Ajaran',
            'Tanggal Pengisian',
            'Total SKS',
            'Jumlah MK',
            'Mata Kuliah yang Diambil',
            'Status Validasi',
        ];
    }

    /**
     * @var Krs $krs
     */
    public function map($krs): array
    {
        static $no = 1;

        // Hitung total SKS
        $totalSks = $krs->details->sum(function($detail) {
            return $detail->mataKuliah->sks ?? 0;
        });

        // Hitung jumlah mata kuliah
        $jumlahMk = $krs->details->count();

        // Daftar mata kuliah yang diambil (dengan line break untuk tampilan vertikal)
        $mataKuliahList = $krs->details->map(function($detail) {
            $mk = $detail->mataKuliah;
            if ($mk) {
                return $mk->kode_matakuliah . ' - ' . $mk->nama_matakuliah . ' (' . $mk->sks . ' SKS)';
            }
            return '-';
        })->implode("\n"); // Gunakan \n untuk line break di Excel

        return [
            $no++,
            $krs->mahasiswa->nama_lengkap ?? '-',
            $krs->mahasiswa->nim ?? '-',
            $krs->mahasiswa->prodi->nama_prodi ?? '-',
            $krs->semester ?? '-',
            $krs->tahun_ajaran ?? '-',
            $krs->tanggal_pengisian ? \Carbon\Carbon::parse($krs->tanggal_pengisian)->format('d/m/Y') : '-',
            $totalSks,
            $jumlahMk,
            $mataKuliahList ?: '-',
            ucfirst($krs->status_validasi ?? 'Menunggu'),
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Get the highest row number
        $highestRow = $sheet->getHighestRow();
        
        // Apply text wrapping to column J (Mata Kuliah)
        $sheet->getStyle('J2:J' . $highestRow)->getAlignment()->setWrapText(true);
        
        // Set VERTICAL_TOP alignment untuk SEMUA KOLOM agar data rapi di atas
        $sheet->getStyle('A2:K' . $highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 25,  // Nama Mahasiswa
            'C' => 15,  // NIM
            'D' => 25,  // Program Studi
            'E' => 10,  // Semester
            'F' => 15,  // Tahun Ajaran
            'G' => 18,  // Tanggal Pengisian
            'H' => 12,  // Total SKS
            'I' => 12,  // Jumlah MK
            'J' => 45,  // Mata Kuliah yang Diambil (lebih pendek karena vertikal)
            'K' => 15,  // Status Validasi
        ];
    }
}
