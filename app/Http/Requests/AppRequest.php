<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppRequest extends FormRequest
{
    public function messages()
    {
        return [
            'required' => 'Untuk :attribute Harus Diisi, Tidak Boleh Kosong',
            'alpha_num' => 'Untuk :attribute Harus Berupa Huruf Dan Angka, Tidak Boleh Selain Itu',
            'unique' => 'Untuk :attribute Harus Data yang belum pernah Ada',
            'file' => 'Untuk :attribute Harus Data File',
            'image' => 'Untuk :attribute Harus Data File Berformat Gambar',
        ];
    }

}
