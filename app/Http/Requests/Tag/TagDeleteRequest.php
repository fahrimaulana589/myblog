<?php

namespace App\Http\Requests\Tag;

use App\Rules\not_exist;
use Illuminate\Foundation\Http\FormRequest;

class TagDeleteRequest extends TagRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => [
                'required',
                'numeric',
                'exists:tags,id',
                new not_exist('blog_tag','tag_id')
            ]
        ];
    }
}
