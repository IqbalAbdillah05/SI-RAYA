<?php

namespace App\Exports;

use App\Models\PresensiDosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PresensiDosenExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
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
        $query = PresensiDosen::with(['dosen', 'lokasi']);

        // Apply filters from index page
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->whereHas('dosen', function($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%')
                             ->orWhere('nidn', 'like', '%' . $search . '%');
                })
                ->orWhereHas('lokasi', function($subQuery) use ($search) {
                    $subQuery->where('nama_lokasi', 'like', '%' . $search . '%');
                })
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        // Filter by dosen
        if (!empty($this->filters['dosen_id'])) {
            $query->where('dosen_id', $this->filters['dosen_id']);
        }

        // Filter by lokasi
        if (!empty($this->filters['lokasi_id'])) {
            $query->where('lokasi_id', $this->filters['lokasi_id']);
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
            'Nama Dosen',
            'NIDN',
            'Email',
            'Waktu Presensi',
            'Status',
            'Presensi Ke',
            'Lokasi',
            'Latitude',
            'Longitude',
            'Jarak (meter)',
            'Keterangan',
        ];
    }

    /**
     * @var PresensiDosen $presensi
     */
    public function map($presensi): array
    {
        static $no = 1;

        return [
            $no++,
            $presensi->dosen->nama_lengkap ?? $presensi->dosen->name ?? '-',
            $presensi->dosen->nidn ?? '-',
            $presensi->dosen->email ?? '-',
            $presensi->waktu_presensi ? \Carbon\Carbon::parse($presensi->waktu_presensi)->format('d/m/Y H:i:s') : '-',
            ucfirst($presensi->status),
            $presensi->presensi_ke ?? '-',
            $presensi->lokasi->nama_lokasi ?? '-',
            $presensi->latitude ?? '0',
            $presensi->longitude ?? '0',
            $presensi->jarak_masuk ?? '0',
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
            'B' => 25,  // Nama Dosen
            'C' => 15,  // NIDN
            'D' => 25,  // Email
            'E' => 20,  // Waktu Presensi
            'F' => 12,  // Status
            'G' => 12,  // Presensi Ke
            'H' => 25,  // Lokasi
            'I' => 12,  // Latitude
            'J' => 12,  // Longitude
            'K' => 15,  // Jarak
            'L' => 30,  // Keterangan
        ];
    }
}
