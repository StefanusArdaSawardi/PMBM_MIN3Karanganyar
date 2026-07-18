<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasCustomId;

class AyahCalonMurid extends Model
{
    use HasCustomId;

    protected $table = 'ayah_calon_murids';
    protected $primaryKey = 'id_ayah';

    public function getPrefix()
    {
        return 'AYH';
    }

    protected $fillable = [
        'nama_ayah',
        'pekerjaan',
        'alamat',
        'nomor_telpon',
    ];

    public function calonMurids()
    {
        return $this->hasMany(CalonMurid::class, 'id_ayah', 'id_ayah');
    }
}
