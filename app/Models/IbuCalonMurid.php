<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasCustomId;

class IbuCalonMurid extends Model
{
    use HasCustomId;

    protected $table = 'ibu_calon_murids';
    protected $primaryKey = 'id_ibu';

    public function getPrefix()
    {
        return 'IBU';
    }

    protected $fillable = [
        'nama_ibu',
        'pekerjaan',
        'alamat',
        'nomor_telpon',
    ];

    public function calonMurids()
    {
        return $this->hasMany(CalonMurid::class, 'id_ibu', 'id_ibu');
    }
}
