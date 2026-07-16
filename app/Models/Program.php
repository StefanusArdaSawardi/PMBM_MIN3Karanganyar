<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'programs';
    protected $primaryKey = 'id_program';

    protected $fillable = [
        'nama_program',
        'kuota_program',
        'persyaratan',
        'image',
        'dss_weights',
    ];

    protected $casts = [
        'dss_weights' => 'array',
    ];

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
