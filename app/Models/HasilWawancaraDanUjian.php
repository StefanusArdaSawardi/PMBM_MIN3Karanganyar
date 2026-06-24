<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilWawancaraDanUjian extends Model
{
    protected $table = 'hasil_wawancara_dan_ujians';
    protected $primaryKey = 'id_hasil';

    protected $fillable = [
        'nilai_ujian',
        'nilai_wawancara',
        'nilai_hafalan',
        'nilai_calistung',
        'nilai_tasmi',
        'nilai_mandiri',
        'nilai_akhir',
        'catatan_otomatis',
        'catatan_manual',
        'catatan',
        'id_murid',
        'id_ayah',
        'id_ibu',
        'id_panitia',
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

    public function panitia()
    {
        return $this->belongsTo(PanitiaPmbm::class, 'id_panitia', 'id_panitia');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program', 'id_program');
    }
}
