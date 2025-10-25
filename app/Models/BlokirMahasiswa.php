<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlokirMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'blokir_mahasiswa';

    protected $fillable = [
        'mahasiswa_id',
        'prodi_id',
        'semester',
        'tahun_ajaran',
        'keterangan',
        'tanggal_blokir',
        'admin_id',
        'status_blokir'
    ];

    protected $casts = [
        'tanggal_blokir' => 'date',
        'semester' => 'integer'
    ];

    // Relasi ke mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    // Relasi ke prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    // Relasi ke admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Scope untuk status blokir
    public function scopeStatusBlokir($query, $status)
    {
        return $query->where('status_blokir', $status);
    }

    // Scope untuk tahun ajaran
    public function scopeTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }
}
