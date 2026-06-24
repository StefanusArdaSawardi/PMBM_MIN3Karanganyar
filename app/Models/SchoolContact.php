<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolContact extends Model
{
    protected $table = 'school_contacts';
    protected $fillable = ['title', 'address', 'phone', 'email', 'maps_link', 'maps_pin_link', 'work_hours'];
}
