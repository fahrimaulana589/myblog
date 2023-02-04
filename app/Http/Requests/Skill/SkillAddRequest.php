<?php

namespace App\Http\Requests\Skill;

use Illuminate\Foundation\Http\FormRequest;

class SkillAddRequest extends SkillRequest
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
}
