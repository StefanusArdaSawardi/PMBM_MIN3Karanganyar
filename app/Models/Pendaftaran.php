<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftarans';
    protected $primaryKey = 'id_pendaftaran';

    protected $fillable = [
        'tanggal_pendaftaran',
        'status_verifikasi',
        'status_kelulusan',
        'status_konfirmasi',
        'alasan_penolakan',
        'peringkat_cadangan',
        'tanggal_verifikasi',
        'tanggal_kelulusan',
        'tanggal_konfirmasi',
        'id_murid',
        'id_program',
    ];

    public function isVerified()
    {
        return $this->status_verifikasi === 'terverifikasi' || $this->status_verifikasi === 'terverifikasi_onsite';
    }
 
    public function isRejected()
    {
        return $this->status_verifikasi === 'ditolak';
    }
 
    public function isLulus()
    {
        return $this->status_kelulusan === 'lulus';
    }
 
    public function isCadangan()
    {
        return $this->status_kelulusan === 'cadangan';
    }

    public function getStatusLabelAttribute()
    {
        if ($this->status_verifikasi === 'ditolak') {
            return 'Berkas Ditolak';
        }
        if ($this->status_verifikasi === 'menunggu_verifikasi') {
            return 'Baru / Menunggu Verifikasi';
        }
        if ($this->status_verifikasi === 'terverifikasi') {
            return 'Berkas Diterima';
        }
        if ($this->status_verifikasi === 'terverifikasi_onsite' && is_null($this->status_kelulusan)) {
            if ($this->calonMurid && $this->calonMurid->hasil()->exists()) {
                return 'Siap Seleksi';
            }
            return 'Berkas Onsite Diterima';
        }
        if ($this->status_kelulusan === 'lulus') {
            if ($this->status_konfirmasi === 'terkonfirmasi') {
                return 'Diterima (Daftar Ulang)';
            }
            if ($this->status_konfirmasi === 'mengundurkan_diri') {
                return 'Mengundurkan Diri';
            }
            return 'Lulus';
        }
        if ($this->status_kelulusan === 'cadangan') {
            return 'Cadangan';
        }
        if ($this->status_kelulusan === 'tidak_lulus') {
            return 'Tidak Lulus';
        }
        return 'Pending';
    }

    public function calonMurid()
    {
        return $this->belongsTo(CalonMurid::class, 'id_murid', 'id_murid');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program', 'id_program');
    }
}
