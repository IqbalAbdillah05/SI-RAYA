<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class MahasiswaImport implements ToModel, WithHeadingRow, SkipsOnError
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
            $nim = $getValue($row, ['nim', 'nomor_induk_mahasiswa']);
            $nikValue = $getValue($row, ['nik', 'nomor_induk_kependudukan']);
            $email = $getValue($row, ['email', 'e_mail']);
            $prodiName = $getValue($row, ['prodi', 'program_studi', 'nama_prodi']);
            
            // Skip row jika semua field penting kosong (row kosong/contoh)
            if (empty($namaLengkap) && empty($nim) && empty($email)) {
                return null;
            }

            DB::beginTransaction();
            
            // Cari prodi berdasarkan nama prodi (case insensitive)
            $prodi = null;
            if (!empty($prodiName)) {
                $prodi = \App\Models\Prodi::whereRaw('LOWER(nama_prodi) = ?', [strtolower($prodiName)])->first();
                if (!$prodi) {
                    throw new \Exception("Prodi '{$prodiName}' tidak ditemukan");
                }
            }

            // Konversi NIK ke string (karena Excel baca sebagai number)
            $nik = null;
            if (!empty($nikValue)) {
                // Konversi ke string, handle scientific notation
                if (is_numeric($nikValue)) {
                    // Gunakan sprintf untuk menghindari scientific notation
                    $nik = sprintf('%.0f', $nikValue);
                } else {
                    $nik = (string) $nikValue;
                }
                
                // Bersihkan karakter non-digit
                $nik = preg_replace('/[^0-9]/', '', $nik);
                
                // Pastikan 16 digit dengan padding 0 di depan jika kurang
                if (strlen($nik) < 16) {
                    $nik = str_pad($nik, 16, '0', STR_PAD_LEFT);
                }
                // Jika lebih dari 16, ambil 16 digit pertama
                elseif (strlen($nik) > 16) {
                    $nik = substr($nik, 0, 16);
                }
            }

            // Konversi NIM ke string
            $nim = (string) $nim;

            // Ambil field lainnya dengan helper
            $semester = $getValue($row, ['semester', 'smt']);
            $jenisKelamin = $getValue($row, ['jenis_kelamin', 'jenis kelamin', 'gender']);
            $tempatLahir = $getValue($row, ['tempat_lahir', 'tempat lahir', 'birthplace']);
            $tanggalLahir = $getValue($row, ['tanggal_lahir', 'tanggal lahir', 'tgl_lahir', 'birthdate']);
            $tanggalMasuk = $getValue($row, ['tanggal_masuk', 'tanggal masuk', 'tgl_masuk']);
            $agama = $getValue($row, ['agama', 'religion']);
            $alamat = $getValue($row, ['alamat', 'address']);
            $noTelpRaw = $getValue($row, ['no_telp', 'no telp', 'telepon', 'phone']);
            $biayaMasuk = $getValue($row, ['biaya_masuk', 'biaya masuk', 'fee']);
            $statusMahasiswa = $getValue($row, ['status_mahasiswa', 'status mahasiswa', 'status']);
            $statusSync = $getValue($row, ['status_sync', 'status sync']);
            $password = $getValue($row, ['password', 'pass']);

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
            if (empty($nim)) {
                throw new \Exception("NIM wajib diisi");
            }
            if (empty($email)) {
                throw new \Exception("Email wajib diisi");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("Format email tidak valid");
            }
            if (empty($prodiName)) {
                throw new \Exception("Nama Prodi wajib diisi");
            }

            // Cek duplicate NIM
            if (User::where('nim', $nim)->exists() || Mahasiswa::where('nim', $nim)->exists()) {
                throw new \Exception("NIM {$nim} sudah terdaftar");
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

            // Parse tanggal lahir dan tanggal masuk
            $tanggalLahirParsed = $parseDate($tanggalLahir);
            $tanggalMasukParsed = !empty($tanggalMasuk) ? $parseDate($tanggalMasuk) : now();

            // Create User
            $user = User::create([
                'name' => $namaLengkap,
                'email' => $email,
                'username' => $nim,
                'nim' => $nim,
                'role' => 'mahasiswa',
                'password' => Hash::make($password ?? ($tanggalLahirParsed ? $tanggalLahirParsed->format('dmY') : $nim)), // Default password = tanggal lahir atau NIM
            ]);

            // Create Mahasiswa Profile
            Mahasiswa::create([
                'user_id' => $user->id,
                'nama_lengkap' => $namaLengkap,
                'nim' => $nim,
                'nik' => $nik,
                'email' => $email,
                'prodi_id' => $prodi ? $prodi->id : null,
                'semester' => $semester ?? 1,
                'jenis_kelamin' => $jenisKelamin ?? 'Laki-laki',
                'tempat_lahir' => $tempatLahir ?? null,
                'tanggal_lahir' => $tanggalLahirParsed,
                'tanggal_masuk' => $tanggalMasukParsed,
                'agama' => $agama ?? 'Islam',
                'alamat' => $alamat ?? null,
                'no_telp' => $noTelp ?? null,
                'biaya_masuk' => $biayaMasuk ?? 0,
                'status_mahasiswa' => $statusMahasiswa ?? 'Aktif',
                'status_sync' => $statusSync ?? 'Belum Sync',
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
