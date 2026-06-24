<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kejuaraan extends Model
{
    protected $table = 'kejuaraans';
    protected $primaryKey = 'id_kejuaraan';

    protected $fillable = [
        'nama_kejuaraan',
        'tanggal_kejuaraan',
        'tingkat_kejuaraan',
        'piagram_kejuaraan',
    ];

    public function calonMurids()
    {
        return $this->hasMany(CalonMurid::class, 'id_kejuaraan', 'id_kejuaraan');
    }
}
