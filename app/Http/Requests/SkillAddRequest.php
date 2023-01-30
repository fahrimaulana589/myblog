<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillAddRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => [
                'file',
                'image',
                'nullable',
            ],
            'name' => [
                'required',
                'alpha_num',
                'unique:skills,name',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
