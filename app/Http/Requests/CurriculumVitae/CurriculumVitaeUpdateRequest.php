<?php

namespace App\Http\Requests\CurriculumVitae;

use App\Http\Requests\AppRequest;
use Illuminate\Foundation\Http\FormRequest;

class CurriculumVitaeUpdateRequest extends AppRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file_1' =>['file','image'],
            'file_2' => ['file','mimetypes:application/pdf'],
            'name' => ['string', 'max:255'],
            'summary' => ['string'],
        ];
    }

    public function attributes()
    {
        return [
            'file_1' => 'Photo CV',
            'file_2' => 'File CV',
            'summary' => 'Rangkuman CV',
            'name' => 'Nama CV',
        ];
    }
}
