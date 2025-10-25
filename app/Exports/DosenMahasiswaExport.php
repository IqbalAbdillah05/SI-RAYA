<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DosenMahasiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $role;

    public function __construct($role = null)
    {
        $this->role = $role;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = User::with(['mahasiswaProfile.prodi', 'dosen'])
            ->whereIn('role', ['dosen', 'mahasiswa'])
            ->orderBy('role', 'asc')
            ->orderBy('name', 'asc');

        // Filter by specific role if provided
        if ($this->role && in_array($this->role, ['dosen', 'mahasiswa'])) {
            $query->where('role', $this->role);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        if ($this->role === 'dosen') {
            return [
                'No',
                'Nama Lengkap',
                'NIDN',
                'Email',
                'Program Studi',
                'Jenis Kelamin',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Agama',
                'Alamat',
                'No. Telepon',
                'Tanggal Daftar',
            ];
        } elseif ($this->role === 'mahasiswa') {
            return [
                'No',
                'Nama Lengkap',
                'NIM',
                'NIK',
                'Email',
                'Program Studi',
                'Semester',
                'Jenis Kelamin',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Tanggal Masuk',
                'Agama',
                'Alamat',
                'No. Telepon',
                'Biaya Masuk',
                'Status Mahasiswa',
                'Status Sync',
                'Tanggal Daftar',
            ];
        }
        
        // Default (shouldn't reach here)
        return [];
    }

    /**
     * @var User $user
     */
    public function map($user): array
    {
        static $no = 1;

        if ($user->role === 'dosen' && $user->dosen) {
            $dosen = $user->dosen;
            return [
                $no++,
                $dosen->nama_lengkap ?? $user->name,
                $dosen->nidn ?? '',
                $dosen->email ?? $user->email,
                $dosen->program_studi ?? '',
                $dosen->jenis_kelamin ?? '',
                $dosen->tempat_lahir ?? '',
                $dosen->tanggal_lahir ? \Carbon\Carbon::parse($dosen->tanggal_lahir)->format('d/m/Y') : '',
                $dosen->agama ?? '',
                $dosen->alamat ?? '',
                $dosen->no_telp ?? '',
                $user->created_at->format('d/m/Y H:i'),
            ];
        } elseif ($user->role === 'mahasiswa' && $user->mahasiswaProfile) {
            $mhs = $user->mahasiswaProfile;
            return [
                $no++,
                $mhs->nama_lengkap ?? $user->name,
                $mhs->nim ?? '',
                $mhs->nik ?? '',
                $mhs->email ?? $user->email,
                $mhs->prodi ? $mhs->prodi->nama_prodi : ($mhs->program_studi ?? ''),
                $mhs->semester ?? '',
                $mhs->jenis_kelamin ?? '',
                $mhs->tempat_lahir ?? '',
                $mhs->tanggal_lahir ? \Carbon\Carbon::parse($mhs->tanggal_lahir)->format('d/m/Y') : '',
                $mhs->tanggal_masuk ? \Carbon\Carbon::parse($mhs->tanggal_masuk)->format('d/m/Y') : '',
                $mhs->agama ?? '',
                $mhs->alamat ?? '',
                $mhs->no_telp ?? '',
                $mhs->biaya_masuk ?? '',
                $mhs->status_mahasiswa ?? '',
                $mhs->status_sync ?? '',
                $user->created_at->format('d/m/Y H:i'),
            ];
        }

        return [];
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
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'font' => [
                    'color' => ['rgb' => 'FFFFFF'],
                    'bold' => true,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        if ($this->role === 'dosen') {
            return [
                'A' => 5,   // No
                'B' => 25,  // Nama Lengkap
                'C' => 15,  // NIDN
                'D' => 25,  // Email
                'E' => 25,  // Program Studi
                'F' => 15,  // Jenis Kelamin
                'G' => 20,  // Tempat Lahir
                'H' => 15,  // Tanggal Lahir
                'I' => 15,  // Agama
                'J' => 30,  // Alamat
                'K' => 15,  // No. Telepon
                'L' => 18,  // Tanggal Daftar
            ];
        } elseif ($this->role === 'mahasiswa') {
            return [
                'A' => 5,   // No
                'B' => 25,  // Nama Lengkap
                'C' => 15,  // NIM
                'D' => 18,  // NIK
                'E' => 25,  // Email
                'F' => 25,  // Program Studi
                'G' => 10,  // Semester
                'H' => 15,  // Jenis Kelamin
                'I' => 20,  // Tempat Lahir
                'J' => 15,  // Tanggal Lahir
                'K' => 15,  // Tanggal Masuk
                'L' => 15,  // Agama
                'M' => 30,  // Alamat
                'N' => 15,  // No. Telepon
                'O' => 15,  // Biaya Masuk
                'P' => 15,  // Status Mahasiswa
                'Q' => 15,  // Status Sync
                'R' => 18,  // Tanggal Daftar
            ];
        }
        
        return [];
    }
}
