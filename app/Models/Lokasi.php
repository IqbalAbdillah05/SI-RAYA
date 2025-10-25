<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lokasi_presensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lokasi',
        'latitude',
        'longitude',
        'radius',
        'dibuat_oleh',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'radius' => 'decimal:2',
    ];

    /**
     * Get the presensi dosen for the lokasi.
     */
    public function presensiDosen()
    {
        return $this->hasMany(PresensiDosen::class, 'lokasi_id');
    }

    /**
     * Get the user that created the lokasi.
     */
    public function pembuatUser()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}