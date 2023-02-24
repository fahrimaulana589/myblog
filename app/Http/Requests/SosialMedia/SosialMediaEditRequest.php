<?php

namespace App\Http\Requests\SosialMedia;

use Illuminate\Foundation\Http\FormRequest;

class SosialMediaEditRequest extends FormRequest
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
            'file' => [
                'file',
                'image',
                'nullable',
            ],
            'name' => [
                'required',
                'alpha_num',
                'unique:social_medias,name,'.$id,
            ],
            'url' => [
                'url',
                'required',
                'unique:social_medias,url,'.$id
            ],
        ];
    }
}
