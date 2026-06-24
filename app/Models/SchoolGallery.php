<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolGallery extends Model
{
    protected $table = 'school_gallery';
    protected $fillable = ['title', 'description', 'image_path', 'order'];
}
