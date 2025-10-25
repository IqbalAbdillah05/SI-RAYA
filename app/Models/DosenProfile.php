<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenProfile extends Model
{
    use HasFactory;

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
        'pas_foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for photo URL
    public function getPasFotoUrlAttribute()
    {
        if ($this->pas_foto) {
            return asset('storage/' . $this->pas_foto);
        }
        return asset('images/default-avatar.png');
    }
}