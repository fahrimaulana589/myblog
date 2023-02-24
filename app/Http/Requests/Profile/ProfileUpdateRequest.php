<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\AppRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends AppRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' =>['file','image'],
            'name' => ['string', 'max:255'],
            'summary' => ['string'],
            'slogan' => ['string'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama Profile',
            'file' => 'Gambar Profile',
            'summary' => 'Summary Profile',
            'slogan' => 'Slogan Profile',
        ];
    }
}
