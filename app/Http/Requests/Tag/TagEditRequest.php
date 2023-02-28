<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

class TagEditRequest extends TagRequest
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
            'name' => [
                'unique:tags,name,'.$id,
                'required',
                'string'
            ],
            'id' => [
                'required',
                'exists:tags,id'
            ]
        ];
    }
}
