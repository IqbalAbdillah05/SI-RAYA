<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khs extends Model
{
    use HasFactory;

    protected $table = 'khs';

    protected $fillable = [
        'mahasiswa_id',
        'prodi_id',
        'semester',
        'tahun_ajaran',
        'total_sks',
        'ips',
        'ipk',
        'status_validasi'
    ];

    protected $casts = [
        'ips' => 'decimal:2',
        'ipk' => 'decimal:2',
        'total_sks' => 'integer'
    ];

    // Relasi dengan Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    // Relasi dengan Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    // Relasi dengan KhsDetail
    public function details()
    {
        return $this->hasMany(KhsDetail::class, 'khs_id');
    }

    // Scope untuk filter berdasarkan semester
    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    // Scope untuk filter berdasarkan tahun ajaran
    public function scopeTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }

    // Scope untuk filter berdasarkan status validasi
    public function scopeStatusValidasi($query, $status)
    {
        return $query->where('status_validasi', $status);
    }
}
