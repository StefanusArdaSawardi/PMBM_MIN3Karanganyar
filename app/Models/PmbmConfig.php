<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PmbmConfig extends Model
{
    protected $table = 'pmbm_configs';
    protected $fillable = ['whatsapp_link', 'email_template'];
}
