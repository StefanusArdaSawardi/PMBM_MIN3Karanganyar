<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Traits\HasCustomId;

class PanitiaPmbm extends Authenticatable
{
    use Notifiable, HasCustomId;

    protected $table = 'panitia_pmbms';
    protected $primaryKey = 'id_panitia';

    protected $fillable = [
        'nama_panitia',
        'no_hp',
        'email',
        'password',
        'password_plain',
        'role_panitia',
    ];

    public function getPrefix()
    {
        return 'PAN';
    }

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
