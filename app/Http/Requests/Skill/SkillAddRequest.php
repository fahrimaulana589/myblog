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
                'required',
            ],
            'name' => [
                'required',
                'string',
                'unique:skills,name',
            ],
        ];
    }
}
