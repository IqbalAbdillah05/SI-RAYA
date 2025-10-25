<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhsDetail extends Model
{
    use HasFactory;

    protected $table = 'khs_detail';

    protected $fillable = [
        'khs_id',
        'mata_kuliah_id',
        'nilai_mahasiswa_id', // Tambahkan kolom ini
        'nilai_angka',
        'nilai_huruf',
        'nilai_indeks',
        'sks'
    ];

    protected $casts = [
        'nilai_angka' => 'decimal:2',
        'nilai_indeks' => 'decimal:2',
        'sks' => 'integer'
    ];

    // Relasi dengan KHS
    public function khs()
    {
        return $this->belongsTo(Khs::class, 'khs_id');
    }

    // Relasi dengan Mata Kuliah
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    // Relasi dengan Nilai Mahasiswa
    public function nilaiMahasiswa()
    {
        return $this->belongsTo(NilaiMahasiswa::class, 'nilai_mahasiswa_id');
    }

    // Method untuk konversi nilai angka ke huruf
    public static function konversiNilaiHuruf($nilaiAngka)
    {
        if ($nilaiAngka >= 85) return 'A';
        if ($nilaiAngka >= 80) return 'A-';
        if ($nilaiAngka >= 75) return 'B+';
        if ($nilaiAngka >= 70) return 'B';
        if ($nilaiAngka >= 65) return 'B-';
        if ($nilaiAngka >= 60) return 'C+';
        if ($nilaiAngka >= 55) return 'C';
        if ($nilaiAngka >= 50) return 'C-';
        if ($nilaiAngka >= 45) return 'D';
        return 'E';
    }

    // Method untuk konversi nilai angka ke indeks
    public static function konversiNilaiIndeks($nilaiAngka)
    {
        if ($nilaiAngka >= 85) return 4.00;
        if ($nilaiAngka >= 80) return 3.75;
        if ($nilaiAngka >= 75) return 3.50;
        if ($nilaiAngka >= 70) return 3.00;
        if ($nilaiAngka >= 65) return 2.75;
        if ($nilaiAngka >= 60) return 2.50;
        if ($nilaiAngka >= 55) return 2.00;
        if ($nilaiAngka >= 50) return 1.75;
        if ($nilaiAngka >= 45) return 1.00;
        return 0.00;
    }

    // Accessor untuk nama mata kuliah
    public function getMatkulNameAttribute()
    {
        return $this->mataKuliah ? $this->mataKuliah->nama_matakuliah : '-';
    }

    // Observer untuk otomatis set nilai huruf dan indeks
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($khsDetail) {
            if ($khsDetail->nilai_angka) {
                $khsDetail->nilai_huruf = self::konversiNilaiHuruf($khsDetail->nilai_angka);
                $khsDetail->nilai_indeks = self::konversiNilaiIndeks($khsDetail->nilai_angka);
            }
        });
    }

    // Scope untuk filter berdasarkan mata kuliah
    public function scopeMataKuliah($query, $mataKuliahId)
    {
        return $query->where('mata_kuliah_id', $mataKuliahId);
    }

    // Scope untuk filter berdasarkan rentang nilai
    public function scopeNilaiRange($query, $min, $max)
    {
        return $query->whereBetween('nilai_angka', [$min, $max]);
    }
}
