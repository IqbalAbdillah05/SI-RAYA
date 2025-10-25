<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prodi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        'jenjang',
        'ketua_prodi',
        'nidn_ketua_prodi'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'jenjang' => 'string'
    ];

    /**
     * Get the mata kuliah for the prodi.
     */
    public function mataKuliah()
    {
        return $this->hasMany(MataKuliah::class);
    }

    /**
     * Scope a query to filter by jenjang.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $jenjang
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeJenjang($query, $jenjang)
    {
        return $query->where('jenjang', $jenjang);
    }

    /**
     * Get the available jenjang options.
     *
     * @return array
     */
    public static function getJenjangOptions()
    {
        return [
            'D3' => 'Diploma 3',
            'D4' => 'Diploma 4',
            'S1' => 'Strata 1',
            'S2' => 'Strata 2',
            'S3' => 'Strata 3'
        ];
    }
}
