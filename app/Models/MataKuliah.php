<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah';

    protected $fillable = [
        'prodi_id',
        'kode_matakuliah',
        'nama_matakuliah',
        'sks',
        'semester',
        'js',
        'jenis_mk'
    ];

    protected $casts = [
        'sks' => 'integer',
        'semester' => 'integer',
        'js' => 'integer',
    ];

    // Validasi kode matakuliah
    public static function rules()
    {
        return [
            'kode_matakuliah' => 'required|string|max:20|unique:mata_kuliah,kode_matakuliah',
        ];
    }
    
    /**
     * Nilai yang valid untuk kolom jenis_mk
     */
    public const JENIS_MK_WAJIB = 'wajib';
    public const JENIS_MK_PILIHAN = 'pilihan';
    public const JENIS_MK_TUGAS_AKHIR = 'tugas akhir';

    // Relasi ke tabel prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    // Relasi ke tabel jadwal
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'mata_kuliah_id');
    }

    // Relasi ke tabel presensi mahasiswa
    public function presensiMahasiswa()
    {
        return $this->hasMany(PresensiMahasiswa::class, 'mata_kuliah_id');
    }
}