<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasCustomId;

class Pendaftaran extends Model
{
    use HasCustomId;

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
        'periode_pendaftaran_id',
        'program_kelulusan',
        'batas_konfirmasi',
    ];

    public function getPrefix()
    {
        return 'PDT';
    }

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

        // Jika status kelulusan sudah diatur, tampilkan status kelulusan ril
        if ($this->status_kelulusan === 'lulus') {
            if ($this->status_konfirmasi === 'terkonfirmasi') {
                return 'Diterima (Daftar Ulang)';
            }
            if ($this->status_konfirmasi === 'tidak_lulus_pmbm') {
                return 'Tidak Lulus PMBM (Melewati Batas Waktu)';
            }
            if ($this->status_konfirmasi === 'mengundurkan_diri') {
                return 'Mengundurkan Diri';
            }
            
            $progName = $this->program_kelulusan ?: ($this->program->nama_program ?? 'Program Studi');
            return 'Lulus Seleksi - ' . $progName;
        }
        if ($this->status_kelulusan === 'cadangan') {
            return 'Cadangan';
        }
        if ($this->status_kelulusan === 'tidak_lulus') {
            return 'Tidak Lulus';
        }
        if ($this->status_verifikasi === 'terverifikasi_onsite') {
            if ($this->calonMurid && $this->calonMurid->hasil()->exists()) {
                return 'Siap Seleksi';
            }
            return 'Berkas Onsite Diterima';
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

    public function periodePendaftaran()
    {
        return $this->belongsTo(PeriodePendaftaran::class, 'periode_pendaftaran_id', 'id');
    }

    public function nilaiUjian()
    {
        return $this->hasOne(NilaiUjian::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function wawancaraAnak()
    {
        return $this->hasOne(WawancaraAnak::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function wawancaraOrtu()
    {
        return $this->hasOne(WawancaraOrtu::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function dssRanking()
    {
        return $this->hasOne(DssRanking::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}
