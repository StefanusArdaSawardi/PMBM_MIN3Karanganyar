<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class DssRanking extends Model
{
    use HasCustomId;

    protected $table = 'dss_rankings';
    protected $primaryKey = 'id_dss';

    protected $fillable = [
        'id_pendaftaran',
        'id_bobot',
        'nilai_total',
        'ranking',
        'rekomendasi',
    ];

    public function getPrefix()
    {
        return 'DSS';
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function bobot()
    {
        return $this->belongsTo(BobotPenilaian::class, 'id_bobot', 'id_bobot');
    }
}
