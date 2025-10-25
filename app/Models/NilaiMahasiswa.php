<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'nilai_mahasiswa';

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'mata_kuliah_id',
        'prodi_id',
        'nilai_angka',
        'nilai_huruf',
        'nilai_indeks',
        'semester',
        'tahun_ajaran',
    ];

    protected $casts = [
        'nilai_angka' => 'decimal:2',
        'nilai_indeks' => 'decimal:2',
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    // Relasi ke Dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    // Relasi ke Mata Kuliah
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    // Relasi ke Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function getMatkulNameAttribute()
    {
        return $this->mataKuliah ? $this->mataKuliah->nama_matakuliah : '-';
    }

    public function getProdiNameAttribute()
    {
        return $this->prodi ? $this->prodi->nama_prodi : '-';
    }

    public function getDosenNameAttribute()
    {
        return $this->dosen ? $this->dosen->nama_lengkap : '-';
    }

    public function getMahasiswaNameAttribute()
    {
        return $this->mahasiswa ? $this->mahasiswa->nama_lengkap : '-';
    }

    // Method untuk konversi nilai angka ke huruf
    public static function konversiNilaiHuruf($nilaiAngka)
    {
        if ($nilaiAngka >= 96) return 'A+';
        if ($nilaiAngka >= 86) return 'A';
        if ($nilaiAngka >= 81) return 'A-';
        if ($nilaiAngka >= 76) return 'B+';
        if ($nilaiAngka >= 71) return 'B';
        if ($nilaiAngka >= 66) return 'B-';
        if ($nilaiAngka >= 61) return 'C+';
        if ($nilaiAngka >= 56) return 'C';
        if ($nilaiAngka >= 41) return 'D';
        return 'E';
    }

    // Method untuk konversi nilai angka ke indeks
    public static function konversiNilaiIndeks($nilaiAngka)
    {
        if ($nilaiAngka >= 96) return 4.00;  // A+
        if ($nilaiAngka >= 86) return 3.50;  // A
        if ($nilaiAngka >= 81) return 3.25;  // A-
        if ($nilaiAngka >= 76) return 3.00;  // B+
        if ($nilaiAngka >= 71) return 2.75;  // B
        if ($nilaiAngka >= 66) return 2.50;  // B-
        if ($nilaiAngka >= 61) return 2.25;  // C+
        if ($nilaiAngka >= 56) return 2.00;  // C
        if ($nilaiAngka >= 41) return 1.00;  // D
        return 0.00;  // E
    }

    // Observer untuk otomatis set nilai huruf dan indeks
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($nilai) {
            if ($nilai->nilai_angka) {
                $nilai->nilai_huruf = self::konversiNilaiHuruf($nilai->nilai_angka);
                $nilai->nilai_indeks = self::konversiNilaiIndeks($nilai->nilai_angka);
            }
        });
    }
}