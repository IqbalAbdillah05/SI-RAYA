<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class DosenImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    protected $errors = [];

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            // Helper function untuk mendapatkan value dengan berbagai kemungkinan key
            $getValue = function($row, $keys) {
                foreach ($keys as $key) {
                    if (isset($row[$key]) && !empty($row[$key])) {
                        return $row[$key];
                    }
                }
                return null;
            };

            // Ambil data dengan berbagai kemungkinan header
            $namaLengkap = $getValue($row, ['nama_lengkap', 'nama lengkap', 'name']);
            $nidn = $getValue($row, ['nidn', 'nomor_induk_dosen_nasional']);
            $email = $getValue($row, ['email', 'e_mail']);
            $prodiName = $getValue($row, ['prodi', 'program_studi', 'nama_prodi']);
            $jenisKelamin = $getValue($row, ['jenis_kelamin', 'jenis kelamin', 'gender']);
            $tempatLahir = $getValue($row, ['tempat_lahir', 'tempat lahir', 'birthplace']);
            $tanggalLahir = $getValue($row, ['tanggal_lahir', 'tanggal lahir', 'tgl_lahir', 'birthdate']);
            $agama = $getValue($row, ['agama', 'religion']);
            $alamat = $getValue($row, ['alamat', 'address']);
            $noTelpRaw = $getValue($row, ['no_telp', 'no telp', 'telepon', 'phone']);
            
            // Skip row jika semua field penting kosong (row kosong/contoh)
            if (empty($namaLengkap) && empty($nidn) && empty($email)) {
                return null;
            }

            DB::beginTransaction();
            $password = $getValue($row, ['password', 'pass']);

            // Konversi NIDN ke string
            $nidn = (string) $nidn;

            // Handle no_telp - tambahkan 0 di depan jika Indonesia dan kehilangan 0
            $noTelp = null;
            if (!empty($noTelpRaw)) {
                $noTelp = (string) $noTelpRaw;
                // Jika dimulai dengan 8 (kehilangan 0 di depan), tambahkan 0
                if (preg_match('/^8\d/', $noTelp)) {
                    $noTelp = '0' . $noTelp;
                }
            }

            // Validasi manual
            if (empty($namaLengkap)) {
                throw new \Exception("Nama lengkap wajib diisi");
            }
            if (empty($nidn)) {
                throw new \Exception("NIDN wajib diisi");
            }
            if (empty($email)) {
                throw new \Exception("Email wajib diisi");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("Format email tidak valid");
            }

            // Cek duplicate NIDN
            if (User::where('nidn', $nidn)->exists() || Dosen::where('nidn', $nidn)->exists()) {
                throw new \Exception("NIDN {$nidn} sudah terdaftar");
            }

            // Cek duplicate Email
            if (User::where('email', $email)->exists()) {
                throw new \Exception("Email {$email} sudah terdaftar");
            }

            // Helper function untuk parsing tanggal dari berbagai format
            $parseDate = function($dateValue) {
                if (empty($dateValue)) {
                    return null;
                }

                try {
                    // Jika sudah dalam bentuk Carbon/DateTime object dari Excel
                    if ($dateValue instanceof \DateTime) {
                        return \Carbon\Carbon::instance($dateValue);
                    }

                    // Jika numeric (Excel serial date)
                    if (is_numeric($dateValue)) {
                        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateValue));
                    }

                    // Jika string, coba parse berbagai format
                    $dateString = trim($dateValue);
                    
                    // Format DD/MM/YYYY (19/05/2005)
                    if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $dateString, $matches)) {
                        return \Carbon\Carbon::createFromFormat('d/m/Y', $dateString);
                    }
                    
                    // Format DD-MM-YYYY (19-05-2005)
                    if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/', $dateString, $matches)) {
                        return \Carbon\Carbon::createFromFormat('d-m-Y', $dateString);
                    }
                    
                    // Format YYYY-MM-DD (2005-05-19)
                    if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $dateString)) {
                        return \Carbon\Carbon::createFromFormat('Y-m-d', $dateString);
                    }
                    
                    // Fallback: biarkan Carbon coba parse otomatis
                    return \Carbon\Carbon::parse($dateString);
                    
                } catch (\Exception $e) {
                    // Jika gagal parse, return null
                    return null;
                }
            };

            // Parse tanggal lahir
            $tanggalLahirParsed = $parseDate($tanggalLahir);

            // Create User
            $user = User::create([
                'name' => $namaLengkap,
                'email' => $email,
                'username' => $nidn,
                'nidn' => $nidn,
                'role' => 'dosen',
                'password' => Hash::make($password ?? $nidn), // Default password = NIDN
            ]);

            // Create Dosen Profile (menggunakan model Dosen, program_studi langsung dari input)
            Dosen::create([
                'user_id' => $user->id,
                'nama_lengkap' => $namaLengkap,
                'nidn' => $nidn,
                'email' => $email,
                'program_studi' => $prodiName, // Langsung ambil dari Excel, bebas isi apa saja
                'jenis_kelamin' => $jenisKelamin ?? 'Laki-laki',
                'tempat_lahir' => $tempatLahir ?? null,
                'tanggal_lahir' => $tanggalLahirParsed,
                'agama' => $agama ?? 'Islam',
                'alamat' => $alamat ?? null,
                'no_telp' => $noTelp,
                'pas_foto' => null,
            ]);

            DB::commit();
            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->errors[] = [
                'row' => $row,
                'error' => $e->getMessage()
            ];
            return null;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
