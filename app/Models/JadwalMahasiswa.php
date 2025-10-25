<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MataKuliah;
use App\Models\Prodi;

class JadwalMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'jadwal_mahasiswa';

    protected $fillable = [
        'mahasiswa_id',
        'jadwal_id'
    ];

    /**
     * Relasi ke model Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke model Jadwal
     */
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    /**
     * Relasi ke model MataKuliah
     */
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    /**
     * Relasi ke model Prodi
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    /**
     * Accessor untuk nama mata kuliah
     */
    public function getMatkulNameAttribute()
    {
        return $this->mataKuliah ? $this->mataKuliah->nama_matakuliah : '-';
    }

    /**
     * Accessor untuk nama prodi
     */
    public function getProdiNameAttribute()
    {
        return $this->prodi ? $this->prodi->nama_prodi : '-';
    }
}