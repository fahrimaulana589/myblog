<?php

namespace App\Http\Requests\Blog;

use App\Rules\not_exist;
use Illuminate\Foundation\Http\FormRequest;

class BlogEditRequest extends BlogRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = request()->get('id');

        return [
            'id' => [
                'required',
                'numeric',
                'exists:blog,id'
            ],
            'name' => [
                'required',
                'unique:blogs,name,'.$id
            ],
            'file' => [
                'file',
                'image',
                'required',
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
                'unique:blogs,comment,'.$id
            ],
        ];
    }
}
