<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\AppRequest;
use Illuminate\Foundation\Http\FormRequest;

class ContactEditRequest extends AppRequest
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
                'string'
            ],
            'summary' => [
                'string'
            ],
            'email' => [
                'email'
            ],
            'whatsapp' => 'numeric',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama Contact',
            'summary' => 'Ringkasan Contact',
            'email' => 'Email Contact',
            'whatsapp' => 'Whatsapp Contact',
        ];
    }


}
