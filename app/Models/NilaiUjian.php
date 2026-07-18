<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class NilaiUjian extends Model
{
    use HasCustomId;

    protected $table = 'nilai_ujians';
    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'id_pendaftaran',
        'id_panitia',
        'nilai_hafalan',
        'nilai_aism',
        'nilai_iqro',
        'nilai_calistung',
        'nilai_dikte',
        'nilai_kemandirian',
    ];

    public function getPrefix()
    {
        return 'NUJ';
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function panitia()
    {
        return $this->belongsTo(PanitiaPmbm::class, 'id_panitia', 'id_panitia');
    }
}
