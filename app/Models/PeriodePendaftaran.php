<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodePendaftaran extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'tahun',
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_program',
        'status',
        'graduation_published',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Cek apakah periode ini sedang dibuka (aktif + dalam rentang tanggal).
     */
    public function isOpen(): bool
    {
        return $this->status === 'aktif'
            && now()->gte($this->tanggal_mulai)
            && now()->lte($this->tanggal_selesai);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $last = static::orderByRaw("CAST(SUBSTR(id, 5) AS INTEGER) DESC")->first();
                $nextNum = $last ? (int) substr($last->id, 4) + 1 : 1;
                $model->id = 'PRD-' . str_pad($nextNum, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'periode_program', 'periode_pendaftaran_id', 'id_program', 'id', 'id_program');
    }

    public function koordinators()
    {
        return $this->belongsToMany(PanitiaPmbm::class, 'periode_koordinator', 'periode_pendaftaran_id', 'id_panitia', 'id', 'id_panitia');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'periode_pendaftaran_id', 'id');
    }
}
