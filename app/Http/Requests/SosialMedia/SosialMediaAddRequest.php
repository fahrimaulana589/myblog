<?php

namespace App\Http\Requests\SosialMedia;

use Illuminate\Foundation\Http\FormRequest;

class SosialMediaAddRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => [
                'file',
                'image',
                'required',
            ],
            'name' => [
                'required',
                'alpha_num',
                'unique:social_medias,name',
            ],
            'url' => [
                'url',
                'required',
                'unique:social_medias,url'
            ],
        ];
    }
}
