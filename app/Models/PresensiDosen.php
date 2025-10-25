<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PresensiDosen extends Model
{
    use HasFactory;

    protected $table = 'presensi_dosen';

    protected $fillable = [
        'dosen_id', 
        'lokasi_id', 
        'waktu_presensi', 
        'status', 
        'presensi_ke', // Tambahkan kolom baru
        'latitude', 
        'longitude', 
        'jarak_masuk', 
        'keterangan', 
        'foto_bukti'
    ];

    protected $casts = [
        'waktu_presensi' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'jarak_masuk' => 'decimal:2',
        'presensi_ke' => 'string' // Tambahkan casting untuk presensi_ke
    ];

    // Relasi dengan Dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    // Relasi dengan Lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    // Scope untuk filter status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter rentang waktu
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('waktu_presensi', [
            Carbon::parse($startDate)->startOfDay(), 
            Carbon::parse($endDate)->endOfDay()
        ]);
    }

    // Accessor untuk status dengan format yang lebih baik
    public function getStatusFormattedAttribute()
    {
        return match($this->status) {
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Tidak Hadir',
            default => $this->status
        };
    }

    // Accessor untuk foto bukti
    public function getFotoBuktiUrlAttribute()
    {
        return $this->foto_bukti 
            ? asset('storage/' . $this->foto_bukti) 
            : asset('images/default-presensi.png');
    }
}