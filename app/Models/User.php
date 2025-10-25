<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role',
        'username',
        'nidn',
        'nim',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ========== Relationships ==========
    
    /**
     * Get the dosen profile associated with this user
     */
    public function dosenProfile()
    {
        return $this->hasOne(Dosen::class);
    }

    /**
     * Get the mahasiswa profile associated with this user
     */
    public function mahasiswaProfile()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    // Alias untuk backward compatibility
    public function dosen()
    {
        return $this->dosenProfile();
    }
    
    public function mahasiswa()
    {
        return $this->mahasiswaProfile();
    }

    // ========== Role Checker Methods ==========
    
    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah dosen
     */
    public function isDosen()
    {
        return $this->role === 'dosen';
    }

    /**
     * Cek apakah user adalah mahasiswa
     */
    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    // ========== Accessors ==========
    
    /**
     * Get profile based on role
     */
    public function getProfileAttribute()
    {
        return match($this->role) {
            'dosen' => $this->dosenProfile,
            'mahasiswa' => $this->mahasiswaProfile,
            default => null,
        };
    }

    /**
     * Get display name
     */
    public function getDisplayNameAttribute()
    {
        if ($this->role === 'mahasiswa' && $this->mahasiswaProfile) {
            return $this->mahasiswaProfile->nama_lengkap;
        }
        
        if ($this->role === 'dosen' && $this->dosenProfile) {
            return $this->dosenProfile->nama_lengkap ?? $this->name;
        }
        
        return $this->name;
    }

    /**
     * Get identifier (NIM for mahasiswa, NIDN for dosen, username for admin)
     */
    public function getIdentifierAttribute()
    {
        return match($this->role) {
            'mahasiswa' => $this->nim ?? ($this->mahasiswaProfile->nim ?? '-'),
            'dosen' => $this->nidn ?? '-',
            default => $this->username ?? $this->email,
        };
    }
    
}