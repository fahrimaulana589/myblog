<?php

namespace App\Http\Requests\Blog;

use App\Http\Requests\AppRequest;
use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends AppRequest
{
    public function attributes()
    {
        return [
            'name' => 'nama blog',
            'image' => 'gambar blog',
            'content' => 'isi blog',
            'date' => 'tanggal blog',
            'comment' => 'comment blog',
        ];
    }

}
