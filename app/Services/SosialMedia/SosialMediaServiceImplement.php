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

    public function update($id, array $data)
    {
        $sosialMediaOld = $this->findOrFail($id);
        $data['icon'] = $this->updatePhoto($sosialMediaOld);

        $result = $this->mainRepository->update($id, $data);

        if ($result) {
            Storage::delete($sosialMediaOld->icon);
        } else {
            Storage::delete($data['icon']);
        }

        return $result;
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

    private function updatePhoto($sosialMediaOld)
    {
        if (request()->get('file') == null) {
            return $sosialMediaOld->icon;
        } elseif (!isset(request()->get('file')->name)) {
            return $sosialMediaOld->icon;
        }

        return request()->get('file')->store('files');
    }
}
