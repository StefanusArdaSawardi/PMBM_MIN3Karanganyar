<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Traits\HasCustomId;

class PengurusTataUsaha extends Authenticatable
{
    use Notifiable, HasCustomId;

    protected $table = 'pengurus_tata_usahas';
    protected $primaryKey = 'id_pengurus';

    public function getPrefix()
    {
        return 'PTU';
    }

    protected $fillable = [
        'nama_pengurus',
        'no_hp',
        'email',
        'password',
        'password_plain',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
