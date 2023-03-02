<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogAddRequest extends BlogRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'unique:blogs,name'
            ],
            'file' => [
                'file',
                'image',
                'required'
            ],
            'content' => [
                'required',
                'string'
            ],
            'date' => [
                'date',
                'required'
            ],
            'comment' => [
                'required',
                'string',
                'unique:blogs,comment'
            ],
        ];
    }
}
