<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodePendaftaran extends Model
{
    protected $fillable = [
        'tahun',
        'judul',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_program',
        'status',
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'periode_program', 'periode_pendaftaran_id', 'id_program', 'id', 'id_program');
    }

    public function koordinators()
    {
        return $this->belongsToMany(PanitiaPmbm::class, 'periode_koordinator', 'periode_pendaftaran_id', 'id_panitia', 'id', 'id_panitia');
    }
}
