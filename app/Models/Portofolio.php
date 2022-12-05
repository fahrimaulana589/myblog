<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = "portofolios";

    protected $fillable = [
        "name",
        "image",
        "content",
        "comment",
    ];

    public function read()
    {
        return $this->morphOne(Read::class,"readable");
    }
}
