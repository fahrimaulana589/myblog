<?php

namespace App\Http\Requests\Education;

use App\Http\Requests\AppRequest;
use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends AppRequest
{
    public function attributes()
    {
        return [
            'name' => 'Nama Pendidikan Terakhir',
            'summary' => 'Ringkasan Pendidikan Terakhir',
            'awal' => 'Tanggal Awal Pendidikan',
            'akhir' => 'Tanggal Akhir Pendidikan',
        ];
    }

}
