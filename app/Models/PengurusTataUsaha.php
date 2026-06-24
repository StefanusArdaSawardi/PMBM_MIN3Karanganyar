<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PengurusTataUsaha extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengurus_tata_usahas';
    protected $primaryKey = 'id_pengurus';

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
