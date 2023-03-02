<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogDeleteRequest extends BlogRequest
{
    public function rules()
    {
        return [
            'id' => [
                'required',
                'numeric',
                'exists:blog,id'
            ]
        ];
    }
}
