<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PmbmSetting extends Model
{
    protected $table = 'pmbm_settings';
    protected $fillable = ['registration_open', 'current_angkatan', 'dss_weights'];

    protected $casts = [
        'registration_open' => 'boolean',
        'dss_weights' => 'array',
    ];
}
