<?php

namespace App\Http\Requests\Experience;

use App\Http\Requests\AppRequest;
use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends AppRequest
{

    public function attributes()
    {
        return [
            'name' => 'Nama Pengalaman Kerja Terakhir',
            'summary' => 'Ringkasan Pengalaman Kerja Terakhir',
            'awal' => 'Tanggal Awal Pengalaman Kerja',
            'akhir' => 'Tanggal Akhir Pengalaman Kerja',
        ];
    }
}
