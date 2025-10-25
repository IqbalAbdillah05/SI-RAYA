<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $table = 'krs';

    protected $fillable = [
        'mahasiswa_id',
        'semester',
        'tahun_ajaran',
        'tanggal_pengisian',
        'status_validasi'
    ];

    protected $casts = [
        'tanggal_pengisian' => 'date',
        'semester' => 'integer'
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    // Relasi ke KRS Detail
    public function details()
    {
        return $this->hasMany(KrsDetail::class, 'krs_id');
    }

    // Alias untuk compatibility
    public function krsDetail()
    {
        return $this->hasMany(KrsDetail::class, 'krs_id');
    }

    // Scope untuk filter semester
    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    // Scope untuk filter tahun ajaran
    public function scopeTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }

    // Scope untuk filter status validasi
    public function scopeStatusValidasi($query, $status)
    {
        return $query->where('status_validasi', $status);
    }
}
