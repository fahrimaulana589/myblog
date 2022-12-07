<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumVitae extends Model
{
    use HasFactory;

    protected $table = 'curriculum_vitaes';

    protected $fillable = [
        'name', 'summary', 'photo', 'file',
    ];
}
