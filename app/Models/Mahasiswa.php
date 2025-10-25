<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_profiles';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim',
        'nik',
        'email',
        'prodi_id',
        'program_studi',
        'semester',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_masuk',
        'agama',
        'alamat',
        'no_telp',
        'pas_foto',
        'biaya_masuk',
        'status_mahasiswa',
        'status_sync',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'semester' => 'integer',
        'biaya_masuk' => 'decimal:2',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Prodi
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    /**
     * Alias for mahasiswaProfile with proper relationship
     */
    public function mahasiswaProfile()
    {
        return new class($this) extends Relation {
            protected $model;

            public function __construct(Model $model)
            {
                $this->model = $model;
                parent::__construct($model::query(), $model);
            }

            public function getEagerLoads()
            {
                return [];
            }

            public function addEagerConstraints(array $models)
            {
                return $this;
            }

            public function initRelation(array $models, $relation)
            {
                foreach ($models as $model) {
                    $model->setRelation($relation, $model);
                }
                return $models;
            }

            public function match(array $models, $results, $relation)
            {
                foreach ($models as $model) {
                    $model->setRelation($relation, $model);
                }
                return $models;
            }

            public function getResults()
            {
                return $this->model;
            }

            public function getQuery()
            {
                return $this->query;
            }

            /**
             * Set the base constraints on the relation query.
             */
            public function addConstraints()
            {
                // No additional constraints needed
                return;
            }

            /**
             * Set the constraints for an eager load of the relation.
             *
             * @param  array  $models
             * @return void
             */
            public function addEagerConstraintsToRelation(array $models)
            {
                // No additional constraints needed
                return;
            }
        };
    }

    /**
     * Relationship with Presensi
     */
    public function presensi()
    {
        return $this->hasMany(PresensiMahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Relationship with Jadwal
     */
    public function jadwal()
    {
        return $this->hasMany(JadwalMahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Relationship with Nilai
     */
    public function nilai()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Relationship with KRS
     */
    public function krs()
    {
        return $this->hasMany(Krs::class, 'mahasiswa_id');
    }

    // Accessors
    public function getNamaProdiAttribute()
    {
        return $this->prodi ? $this->prodi->nama_prodi : ($this->attributes['program_studi'] ?? '-');
    }

    public function getProgramStudiAttribute()
    {
        return $this->prodi ? $this->prodi->nama_prodi : ($this->attributes['program_studi'] ?? '-');
    }

    public function getPasFotoUrlAttribute()
    {
        if ($this->pas_foto) {
            return asset('storage/' . $this->pas_foto);
        }
        return asset('images/default-avatar.png');
    }

    public function getBiayaMasukFormattedAttribute()
    {
        return 'Rp ' . number_format($this->biaya_masuk, 0, ',', '.');
    }

    // Scopes
    public function scopeProdi($query, $prodiId)
    {
        return $query->where('prodi_id', $prodiId);
    }

    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    public function scopeAktif($query)
    {
        return $query->where('status_mahasiswa', 'aktif');
    }

    /**
     * Get mahasiswa by NIM
     */
    public static function findByNim($nim)
    {
        return static::where('nim', $nim)->first();
    }
}