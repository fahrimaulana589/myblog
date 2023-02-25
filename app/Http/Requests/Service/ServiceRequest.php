<?php

namespace App\Http\Requests\Service;

use App\Http\Requests\AppRequest;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends AppRequest
{
    public function attributes()
    {
        return [
            'name' => 'Nama Pelayanan',
            'file' => 'Icon Pelayanan',
            'summary' => 'Ringkasan Pelayanan',
        ];
    }

}
