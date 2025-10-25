<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'presensi_mahasiswa';

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'waktu_presensi',
        'status',
        'semester',
        'keterangan',
        'foto_bukti',
        'mata_kuliah_id',
        'prodi_id'
    ];

    protected $casts = [
        'waktu_presensi' => 'datetime',
        'semester' => 'integer'
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

    // Scope untuk filter berdasarkan status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan semester
    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    // Scope untuk filter berdasarkan mahasiswa
    public function scopeMahasiswa($query, $mahasiswaId)
    {
        return $query->where('mahasiswa_id', $mahasiswaId);
    }

    // Accessor untuk mendapatkan badge warna status
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'hadir' => 'success',
            'izin' => 'warning',
            'sakit' => 'info',
            'alpha' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    // Accessor untuk format tanggal Indonesia
    public function getFormatTanggalAttribute()
    {
        return $this->waktu_presensi->format('d/m/Y H:i');
    }
}