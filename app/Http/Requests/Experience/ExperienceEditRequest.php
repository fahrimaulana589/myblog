<?php

namespace App\Http\Requests\Experience;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceEditRequest extends ExperienceRequest
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
