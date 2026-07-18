<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class ProgramCriterion extends Model
{
    use HasCustomId;

    protected $table = 'program_criteria';
    protected $primaryKey = 'id_kriteria';

    protected $fillable = [
        'id_program',
        'nama_kriteria',
        'nilai_minimum',
    ];

    public function getPrefix()
    {
        return 'KRI';
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program', 'id_program');
    }
}
