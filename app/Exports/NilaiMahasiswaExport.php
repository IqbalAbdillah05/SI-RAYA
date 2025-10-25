<?php

namespace App\Exports;

use App\Models\NilaiMahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiMahasiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
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
        $query = NilaiMahasiswa::with(['mahasiswa', 'dosen', 'mataKuliah', 'prodi']);

        // Apply filters from index page
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->whereHas('mahasiswa', function($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', '%' . $search . '%')
                             ->orWhere('nim', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('mataKuliah', function($subQuery) use ($search) {
                    $subQuery->where('nama_matakuliah', 'like', '%' . $search . '%')
                             ->orWhere('kode_matakuliah', 'like', '%' . $search . '%');
                })
                ->orWhereHas('dosen', function($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', '%' . $search . '%')
                             ->orWhere('nidn', 'like', '%' . $search . '%');
                })
                ->orWhereHas('prodi', function($subQuery) use ($search) {
                    $subQuery->where('nama_prodi', 'like', '%' . $search . '%');
                })
                ->orWhere('nilai_angka', 'like', '%' . $search . '%')
                ->orWhere('nilai_huruf', 'like', '%' . $search . '%')
                ->orWhere('tahun_ajaran', 'like', '%' . $search . '%')
                ->orWhere('semester', 'like', '%' . $search . '%');
            });
        }

        // Filter by mahasiswa
        if (!empty($this->filters['mahasiswa_id'])) {
            $query->where('mahasiswa_id', $this->filters['mahasiswa_id']);
        }

        // Filter by mata kuliah
        if (!empty($this->filters['mata_kuliah_id'])) {
            $query->where('mata_kuliah_id', $this->filters['mata_kuliah_id']);
        }

        // Filter by prodi
        if (!empty($this->filters['prodi_id'])) {
            $query->where('prodi_id', $this->filters['prodi_id']);
        }

        // Filter by semester
        if (!empty($this->filters['semester'])) {
            $query->where('semester', $this->filters['semester']);
        }

        // Filter by tahun ajaran
        if (!empty($this->filters['tahun_ajaran'])) {
            $query->where('tahun_ajaran', $this->filters['tahun_ajaran']);
        }

        return $query->latest()->get();
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
            'Mata Kuliah',
            'Kode MK',
            'Dosen Pengampu',
            'Nilai Angka',
            'Nilai Huruf',
            'Nilai Indeks',
        ];
    }

    /**
     * @var NilaiMahasiswa $nilai
     */
    public function map($nilai): array
    {
        static $no = 1;

        return [
            $no++,
            $nilai->mahasiswa->nama_lengkap ?? '-',
            $nilai->mahasiswa->nim ?? '-',
            $nilai->prodi->nama_prodi ?? '-',
            $nilai->semester ?? '-',
            $nilai->tahun_ajaran ?? '-',
            $nilai->mataKuliah->nama_matakuliah ?? '-',
            $nilai->mataKuliah->kode_matakuliah ?? '-',
            $nilai->dosen->nama_lengkap ?? '-',
            $nilai->nilai_angka ?? '-',
            $nilai->nilai_huruf ?? '-',
            $nilai->nilai_indeks ?? '-',
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
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
            'G' => 30,  // Mata Kuliah
            'H' => 12,  // Kode MK
            'I' => 25,  // Dosen Pengampu
            'J' => 12,  // Nilai Angka
            'K' => 12,  // Nilai Huruf
            'L' => 12,  // Nilai Indeks
        ];
    }
}
