<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceEditRequest extends ServiceRequest
{

    public function rules()
    {
        $id = request()->get('id');

        return [
            'name' => [
                'required',
                'string',
                'unique:services,name,'.$id
            ],
            'file'=>[
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
