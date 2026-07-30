<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasCustomId;

class Program extends Model
{
    use HasCustomId;

    protected $table = 'programs';
    protected $primaryKey = 'id_program';

    protected $fillable = [
        'nama_program',
        'kuota_program',
        'persyaratan',
        'poin_unggulan',
        'image',
        'dss_weights',
        'jenis_penilaian',
        'threshold_nilai_min',
        'threshold_nilai_max',
    ];

    protected $casts = [
        'dss_weights' => 'array',
        'poin_unggulan' => 'array',
    ];

    public function getPrefix()
    {
        return 'PRG';
    }

    public function getImagesAttribute()
    {
        $val = $this->attributes['image'] ?? null;
        if (empty($val)) {
            return [];
        }
        $decoded = json_decode($val, true);
        if (is_array($decoded)) {
            return $decoded;
        }
        return [$val];
    }

    public function criteria()
    {
        return $this->hasMany(ProgramCriterion::class, 'id_program', 'id_program');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'id_program', 'id_program');
    }

    public function getBadgeColorAttribute()
    {
        return match (strtolower($this->nama_program)) {
            'tahfidz' => ['bg' => '#ffdcc3', 'text' => '#2f1500'],
            'sains' => ['bg' => '#1a6fba', 'text' => '#ffffff'],
            'fullday' => ['bg' => '#ba7d1a', 'text' => '#ffffff'],
            default => ['bg' => '#ffdcc3', 'text' => '#2f1500'],
        };
    }
}
