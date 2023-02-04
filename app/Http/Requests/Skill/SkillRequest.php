<?php

namespace App\Http\Requests\Skill;

use App\Http\Requests\AppRequest;
use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends AppRequest
{

    public function attributes()
    {
        return [
          'name' => 'Nama Skill',
          'file' => 'Icon Skill',
        ];
    }
}
