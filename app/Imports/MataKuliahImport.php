<?php

namespace App\Imports;

use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class MataKuliahImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    protected $errors = [];
    protected $successCount = 0;

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
            $kodeMataKuliah = $getValue($row, ['kode_matakuliah', 'kode_mk', 'kode mata kuliah', 'kode']);
            $namaMataKuliah = $getValue($row, ['nama_matakuliah', 'nama_mk', 'nama mata kuliah', 'nama']);
            $prodiName = $getValue($row, ['prodi', 'program_studi', 'nama_prodi']);
            $sks = $getValue($row, ['sks', 'jumlah_sks']);
            $jenisMk = $getValue($row, ['jenis_mk', 'jenis_matakuliah', 'jenis mata kuliah', 'jenis']);
            $semester = $getValue($row, ['semester', 'smt']);
            $js = $getValue($row, ['js', 'jam_simulasi', 'jam_studi']);

            // Skip row jika semua field penting kosong (row kosong/contoh)
            if (empty($kodeMataKuliah) && empty($namaMataKuliah) && empty($prodiName)) {
                \Log::info('Skipping empty row', ['row' => $row]);
                return null;
            }

            // Log data yang akan diproses
            \Log::info('Processing mata kuliah row', [
                'kode' => $kodeMataKuliah,
                'nama' => $namaMataKuliah,
                'prodi' => $prodiName
            ]);

            DB::beginTransaction();

            // Validasi manual
            if (empty($kodeMataKuliah)) {
                throw new \Exception("Kode Mata Kuliah wajib diisi");
            }
            if (empty($namaMataKuliah)) {
                throw new \Exception("Nama Mata Kuliah wajib diisi");
            }
            if (empty($prodiName)) {
                throw new \Exception("Nama Prodi wajib diisi");
            }

            // Cari prodi berdasarkan nama prodi (case insensitive)
            $prodi = Prodi::whereRaw('LOWER(nama_prodi) = ?', [strtolower(trim($prodiName))])->first();
            if (!$prodi) {
                throw new \Exception("Prodi '{$prodiName}' tidak ditemukan di database");
            }

            // Cek duplicate kode mata kuliah
            if (MataKuliah::where('kode_matakuliah', $kodeMataKuliah)->exists()) {
                throw new \Exception("Kode Mata Kuliah '{$kodeMataKuliah}' sudah terdaftar");
            }

            // Normalisasi jenis mata kuliah
            $jenisMkNormalized = strtolower(trim($jenisMk ?? 'wajib'));
            $jenisMkValid = in_array($jenisMkNormalized, ['wajib', 'pilihan', 'tugas akhir']) 
                ? $jenisMkNormalized 
                : 'wajib';

            // Validasi SKS
            $sksValue = $sks ? intval($sks) : 2;
            if ($sksValue < 1 || $sksValue > 6) {
                throw new \Exception("SKS harus antara 1-6, nilai: {$sksValue}");
            }

            // Validasi Semester
            $semesterValue = $semester ? intval($semester) : 1;
            if ($semesterValue < 1 || $semesterValue > 8) {
                throw new \Exception("Semester harus antara 1-8, nilai: {$semesterValue}");
            }

            // Validasi JS (opsional)
            $jsValue = null;
            if (!empty($js)) {
                $jsValue = intval($js);
                if ($jsValue < 1 || $jsValue > 6) {
                    throw new \Exception("JS (Jam Simulasi) harus antara 1-6, nilai: {$jsValue}");
                }
            }

            // Buat Mata Kuliah
            $mataKuliah = MataKuliah::create([
                'prodi_id' => $prodi->id,
                'kode_matakuliah' => trim($kodeMataKuliah),
                'nama_matakuliah' => trim($namaMataKuliah),
                'sks' => $sksValue,
                'jenis_mk' => $jenisMkValid,
                'semester' => $semesterValue,
                'js' => $jsValue,
            ]);

            DB::commit();
            $this->successCount++;
            
            \Log::info('Mata kuliah imported successfully', [
                'id' => $mataKuliah->id,
                'kode' => $mataKuliah->kode_matakuliah
            ]);
            
            return $mataKuliah;

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Import error for mata kuliah', [
                'row' => $row,
                'error' => $e->getMessage()
            ]);
            
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

    public function getSuccessCount()
    {
        return $this->successCount;
    }
}