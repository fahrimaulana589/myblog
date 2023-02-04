<?php

namespace App\Http\Requests\Skill;

use Illuminate\Foundation\Http\FormRequest;

class SkillEditRequest extends SkillRequest
{
    public function rules(): array
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
                'unique:skills,name,'.$id,
            ],
        ];
    }

}
