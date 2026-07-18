<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class WawancaraAnak extends Model
{
    use HasCustomId;

    protected $table = 'wawancara_anaks';
    protected $primaryKey = 'id_wawancara_anak';

    protected $fillable = [
        'id_pendaftaran',
        'id_panitia',
        'wawancara_aism',
        'wawancara_irqa',
        'wawancara_calistung',
        'wawancara_dikte',
        'wawancara_kemandirian',
        'rekap_wawancara',
    ];

    public function getPrefix()
    {
        return 'WAN';
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
