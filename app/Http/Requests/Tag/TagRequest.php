<?php

namespace App\Http\Requests\Tag;

use App\Http\Requests\AppRequest;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends AppRequest
{
    public function attributes()
    {
        return [
            'name' => 'Nama Tag',
            'id' => 'Tag'
        ];
    }

}
