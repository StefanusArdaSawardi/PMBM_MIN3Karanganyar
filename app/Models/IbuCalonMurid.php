<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuCalonMurid extends Model
{
    protected $table = 'ibu_calon_murids';
    protected $primaryKey = 'id_ibu';

    protected $fillable = [
        'nama_ibu',
        'pekerjaan',
        'alamat',
        'nomor_telpon',
        'email',
    ];

    public function calonMurids()
    {
        return $this->hasMany(CalonMurid::class, 'id_ibu', 'id_ibu');
    }
}
