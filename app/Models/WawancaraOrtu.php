<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class WawancaraOrtu extends Model
{
    use HasCustomId;

    protected $table = 'wawancara_ortus';
    protected $primaryKey = 'id_wawancara_ortu';

    protected $fillable = [
        'id_pendaftaran',
        'id_panitia',
        'komitmen_ortu',
    ];

    public function getPrefix()
    {
        return 'WOR';
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
