<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PmbmPhase extends Model
{
    protected $table = 'pmbm_phases';
    protected $primaryKey = 'id_phase';

    protected $fillable = [
        'nama_phase',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'urutan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    /**
     * Check if phase is currently active
     */
    public function isActive()
    {
        $now = now();
        return $this->tanggal_mulai <= $now && $now <= $this->tanggal_selesai;
    }

    /**
     * Get duration in days
     */
    public function getDurationInDays()
    {
        return $this->tanggal_selesai->diffInDays($this->tanggal_mulai);
    }

    /**
     * Get remaining time as formatted string
     */
    public function getRemainingTime()
    {
        if (!$this->isActive()) {
            return null;
        }

        $now = now();
        $remaining = $this->tanggal_selesai->diff($now);

        $days = $remaining->days;
        $hours = $remaining->h;
        $minutes = $remaining->i;

        return "{$days}d {$hours}h {$minutes}m";
    }

    /**
     * Get phase progress percentage
     */
    public function getProgressPercentage()
    {
        $total = $this->tanggal_selesai->diffInSeconds($this->tanggal_mulai);
        $elapsed = now()->diffInSeconds($this->tanggal_mulai);

        if ($elapsed >= $total) {
            return 100;
        }

        return round(($elapsed / $total) * 100);
    }

    /**
     * Get phase status description
     */
    public function getStatusDescription()
    {
        if ($this->status === 'completed') {
            return 'Selesai';
        }

        if ($this->isActive()) {
            return 'Sedang Berlangsung';
        }

        $now = now();
        if ($this->tanggal_mulai > $now) {
            return 'Akan Datang';
        }

        return 'Tertutup';
    }
}
