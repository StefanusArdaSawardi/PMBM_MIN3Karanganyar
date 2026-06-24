<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AyahCalonMurid extends Model
{
    protected $table = 'ayah_calon_murids';
    protected $primaryKey = 'id_ayah';

    protected $fillable = [
        'nama_ayah',
        'pekerjaan',
        'alamat',
        'nomor_telpon',
        'email',
    ];

    public function calonMurids()
    {
        return $this->hasMany(CalonMurid::class, 'id_ayah', 'id_ayah');
    }
}
