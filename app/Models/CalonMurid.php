<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasCustomId;

class CalonMurid extends Model
{
    use HasCustomId;

    protected $table = 'calon_murids';
    protected $primaryKey = 'id_murid';

    public function getPrefix()
    {
        return 'MRD';
    }

    protected $fillable = [
        'nama_murid',
        'jenis_kelamin',
        'nik',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'email',
        'kartu_keluarga',
        'akta_kelahiran',
        'kartu_identitas_anak',
        'pas_foto',
        'id_ayah',
        'id_ibu',
        'piagram_kejuaraan',
    ];

    public function ayah()
    {
        return $this->belongsTo(AyahCalonMurid::class, 'id_ayah', 'id_ayah');
    }

    public function ibu()
    {
        return $this->belongsTo(IbuCalonMurid::class, 'id_ibu', 'id_ibu');
    }



    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class, 'id_murid', 'id_murid');
    }

    public function jadwal()
    {
        return $this->hasOne(JadwalWawancaraDanUjian::class, 'id_murid', 'id_murid');
    }

    public function hasil()
    {
        return $this->hasOne(HasilWawancaraDanUjian::class, 'id_murid', 'id_murid');
    }
}
