<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceAddRequest extends ServiceRequest
{

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'unique:services,name'
            ],
            'file'=>[
                'required',
                'file',
                'image',
            ],
            'summary' => [
                'required',
                'string',
            ],
        ];
    }
}
