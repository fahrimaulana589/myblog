<?php

namespace App\Http\Requests\Education;

use Illuminate\Foundation\Http\FormRequest;

class EducationEditRequest extends FormRequest
{

    public function rules()
    {
        $id = request()->get('id');

        return [
            'name' => [
                'required',
                'string',
                'unique:educations,name,'.$id
            ],
            'summary' => [
                'required',
                'string'
            ],
            'awal' => [
                'required',
                'date'
            ],
            'akhir' => [
                'required',
                'date'
            ],
        ];
    }
}
