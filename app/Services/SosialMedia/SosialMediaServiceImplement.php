<?php

namespace App\Services\SosialMedia;

use App\Repositories\SosialMedia\SosialMediaRepository;
use Illuminate\Http\UploadedFile;
use LaravelEasyRepository\Service;
use Storage;

class SosialMediaServiceImplement extends Service implements SosialMediaService
{
    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(SosialMediaRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function create($data)
    {
        $data['icon'] = $this->getPhoto();

        return $this->mainRepository->create($data);
    }

    private function getPhoto()
    {
        if (request()->get('file') == null) {
            return UploadedFile::fake()->image('avatar.jpg')->store('files');
        } elseif (!isset(request()->get('file')->name)) {
            return UploadedFile::fake()->image('avatar.jpg')->store('files');
        }

        return request()->get('file')->store('files');
    }

    public function update($id, array $data)
    {
        $sosialMediaOld = $this->findOrFail($id);
        $image = $this->updatePhoto($sosialMediaOld);

        $data['icon'] = $image['url'];

        $result = $this->mainRepository->update($id, $data);

        if ($result) {
            if($image['code'] == 3){
                $this->deletePhoto($sosialMediaOld->icon);
            }
        } else {
            $this->deletePhoto($data['icon']);
        }

        return $result;
    }

    private function updatePhoto($sosialMediaOld)
    {
        if (request()->get('file') == null) {
            return [
                'status' => 'file upload kosong',
                'code' => 1,
                'url' => $sosialMediaOld->icon
            ];
        } elseif (!isset(request()->get('file')->name)) {
            return [
                'status' => 'file upload bukan file',
                'code' => 2,
                'url' => $sosialMediaOld->icon
            ];
        }
        return [
            'status' => 'file upload baru',
            'code' => 3,
            'url' => request()->get('file')->store('files')
        ];
    }

    private function deletePhoto($sosialMediaFile)
    {
        return Storage::delete($sosialMediaFile);
    }

    public function delete($id)
    {
        $sosialMedia = $this->mainRepository->findOrFail($id);
        $result = $this->mainRepository->delete($id);

        if ($result) {
            $this->deletePhoto($sosialMedia->icon);
        }

        return $result;
    }

}
