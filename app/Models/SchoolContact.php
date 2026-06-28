<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolContact extends Model
{
    protected $table = 'school_contacts';
    protected $fillable = ['platform_name', 'value', 'link', 'icon'];
}
