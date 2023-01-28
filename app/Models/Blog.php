<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'name',
        'image',
        'content',
        'date',
        'comment',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function read()
    {
        return $this->morphOne(Read::class, 'readable');
    }


}
