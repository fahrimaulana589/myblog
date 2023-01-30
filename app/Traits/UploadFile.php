<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFile
{
    private function getPhoto()
    {
        if (request()->get('file') == null) {
            return UploadedFile::fake()->image(fake()->uuid().'.jpg')->store('files');
        } elseif (! isset(request()->get('file')->name)) {
            return UploadedFile::fake()->image(fake()->uuid().'.jpg')->store('files');
        }

        return request()->get('file')->store('files');
    }

    private function updatePhoto($sosialMediaOld)
    {
        if (request()->get('file') == null) {
            return [
                'status' => 'file upload kosong',
                'code' => 1,
                'url' => $sosialMediaOld->icon,
            ];
        } elseif (! isset(request()->get('file')->name)) {
            return [
                'status' => 'file upload bukan file',
                'code' => 2,
                'url' => $sosialMediaOld->icon,
            ];
        }

        return [
            'status' => 'file upload baru',
            'code' => 3,
            'url' => request()->get('file')->store('files'),
        ];
    }

    private function deletePhoto($sosialMediaFile)
    {
        return Storage::delete($sosialMediaFile);
    }
}
