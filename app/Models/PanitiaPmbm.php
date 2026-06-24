<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PanitiaPmbm extends Authenticatable
{
    use Notifiable;

    protected $table = 'panitia_pmbms';
    protected $primaryKey = 'id_panitia';

    protected $fillable = [
        'nama_panitia',
        'no_hp',
        'email',
        'password',
        'password_plain',
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
