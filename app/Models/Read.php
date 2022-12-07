<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Read extends Model
{
    use HasFactory;

    protected $table = 'reads';

    protected $fillable = [
        'count',
    ];

    public function readable()
    {
        return $this->morphTo();
    }
}
