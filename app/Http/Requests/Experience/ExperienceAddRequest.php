<?php

namespace App\Http\Requests\Experience;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceAddRequest extends ExperienceRequest
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
