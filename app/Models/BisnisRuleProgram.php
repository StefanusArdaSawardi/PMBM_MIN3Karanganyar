<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class BisnisRuleProgram extends Model
{
    use HasCustomId;

    protected $table = 'bisnis_rule_programs';
    protected $primaryKey = 'id_rule';

    protected $fillable = [
        'id_program',
        'minimal_nilai_akhir',
        'minimal_hafalan',
        'minimal_tasmi',
        'minimal_calistung',
    ];

    public function getPrefix()
    {
        return 'BRL';
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program', 'id_program');
    }
}
