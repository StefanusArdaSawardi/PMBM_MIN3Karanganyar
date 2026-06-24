<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProgram extends Model
{
    protected $table = 'school_programs';
    protected $fillable = ['tab_key', 'title', 'subtitle', 'tag', 'description', 'features', 'image_path'];
}
