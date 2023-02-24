<?php

namespace App\Http\Requests\Education;

use Illuminate\Foundation\Http\FormRequest;

class EducationAddRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'unique:educations,name'
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
