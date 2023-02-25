<?php

namespace App\Http\Requests\SosialMedia;

use App\Http\Requests\AppRequest;
use Illuminate\Foundation\Http\FormRequest;

class SosialMediaRequest extends AppRequest
{
    public function attributes()
    {
        return [
            'file' => 'Icon Sosial Media',
            'name' => 'Nama Sosial Media',
            'url' => 'Url Sosial Media',
        ];
    }
}
