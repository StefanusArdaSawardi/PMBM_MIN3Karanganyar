<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class BobotPenilaian extends Model
{
    use HasCustomId;

    protected $table = 'bobot_penilainans';
    protected $primaryKey = 'id_bobot';

    protected $fillable = [
        'bobot_hafalan',
        'bobot_tasmi',
        'bobot_calistung',
        'bobot_wawancara',
        'bobot_mandiri',
        'bobot_aism',
        'bobot_irqa',
        'bobot_dikte',
        'bobot_kemandirian',
        'bobot_komitmenortu',
    ];

    public function getPrefix()
    {
        return 'BBT';
    }
}
