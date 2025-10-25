<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KrsDetail extends Model
{
    use HasFactory;

    protected $table = 'krs_detail';

    protected $fillable = [
        'krs_id',
        'jadwal_id',
        'mata_kuliah_id'
    ];

    // Relasi ke KRS
    public function krs()
    {
        return $this->belongsTo(Krs::class, 'krs_id');
    }

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    // Relasi ke MataKuliah
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    // Accessor untuk nama mata kuliah
    public function getMatkulNameAttribute()
    {
        return $this->jadwal && $this->jadwal->mataKuliah 
            ? $this->jadwal->mataKuliah->nama_matakuliah 
            : '-';
    }

    // Accessor untuk kode mata kuliah
    public function getMatkulCodeAttribute()
    {
        return $this->jadwal && $this->jadwal->mataKuliah 
            ? $this->jadwal->mataKuliah->kode_matakuliah 
            : '-';
    }
}
