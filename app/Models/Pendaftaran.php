<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftarans';
    protected $primaryKey = 'id_pendaftaran';

    protected $fillable = [
        'tanggal_pendaftaran',
        'status',
        'id_murid',
        'id_program',
    ];

    public function calonMurid()
    {
        return $this->belongsTo(CalonMurid::class, 'id_murid', 'id_murid');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program', 'id_program');
    }
}
