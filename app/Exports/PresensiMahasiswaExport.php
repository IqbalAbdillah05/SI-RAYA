<?php

namespace App\Exports;

use App\Models\PresensiMahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PresensiMahasiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
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
        $query = PresensiMahasiswa::with(['mahasiswa', 'dosen', 'mataKuliah', 'prodi']);

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
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        // Filter by mahasiswa
        if (!empty($this->filters['mahasiswa_id'])) {
            $query->where('mahasiswa_id', $this->filters['mahasiswa_id']);
        }

        // Filter by dosen
        if (!empty($this->filters['dosen_id'])) {
            $query->where('dosen_id', $this->filters['dosen_id']);
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

        // Filter by date range
        if (!empty($this->filters['tanggal_dari'])) {
            $query->whereDate('waktu_presensi', '>=', $this->filters['tanggal_dari']);
        }
        if (!empty($this->filters['tanggal_sampai'])) {
            $query->whereDate('waktu_presensi', '<=', $this->filters['tanggal_sampai']);
        }

        return $query->latest('waktu_presensi')->get();
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
            'Mata Kuliah',
            'Dosen Pengampu',
            'Waktu Presensi',
            'Status',
            'Keterangan',
        ];
    }

    /**
     * @var PresensiMahasiswa $presensi
     */
    public function map($presensi): array
    {
        static $no = 1;

        return [
            $no++,
            $presensi->mahasiswa->nama_lengkap ?? '-',
            $presensi->mahasiswa->nim ?? '-',
            $presensi->prodi->nama_prodi ?? '-',
            $presensi->semester ?? '-',
            $presensi->mataKuliah ? $presensi->mataKuliah->nama_matakuliah . ' (' . $presensi->mataKuliah->kode_matakuliah . ')' : '-',
            $presensi->dosen->nama_lengkap ?? '-',
            $presensi->waktu_presensi ? \Carbon\Carbon::parse($presensi->waktu_presensi)->format('d/m/Y H:i:s') : '-',
            ucfirst($presensi->status),
            $presensi->keterangan ?? '-',
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
            'F' => 30,  // Mata Kuliah
            'G' => 25,  // Dosen Pengampu
            'H' => 20,  // Waktu Presensi
            'I' => 12,  // Status
            'J' => 30,  // Keterangan
        ];
    }
}
