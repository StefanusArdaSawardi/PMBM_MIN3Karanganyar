<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalWawancaraDanUjian extends Model
{
    protected $table = 'jadwal_wawancara_dan_ujians';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'tanggal_jadwal',
        'jam_jadwal',
        'id_murid',
        'id_ayah',
        'id_ibu',
        'id_program',
    ];

    public function calonMurid()
    {
        return $this->belongsTo(CalonMurid::class, 'id_murid', 'id_murid');
    }

    public function ayah()
    {
        return $this->belongsTo(AyahCalonMurid::class, 'id_ayah', 'id_ayah');
    }

    public function ibu()
    {
        return $this->belongsTo(IbuCalonMurid::class, 'id_ibu', 'id_ibu');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program', 'id_program');
    }
}
