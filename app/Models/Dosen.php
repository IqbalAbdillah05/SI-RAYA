<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen_profiles';
    protected $fillable = [
        'user_id', 
        'nama_lengkap', 
        'nidn', 
        'email',
        'program_studi',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'no_telp',
        'pas_foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presensi()
    {
        return $this->hasMany(PresensiDosen::class);
    }

    public function nilaiMahasiswa()
    {
        return $this->hasMany(NilaiMahasiswa::class);
    }
}