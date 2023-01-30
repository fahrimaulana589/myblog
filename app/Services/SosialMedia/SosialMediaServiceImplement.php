<?php

namespace App\Services\SosialMedia;

use App\Repositories\SosialMedia\SosialMediaRepository;
use App\Traits\UploadFile;
use LaravelEasyRepository\Service;

class SosialMediaServiceImplement extends Service implements SosialMediaService
{
    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    use UploadFile;

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
        $sosialMediaOld = $this->mainRepository->findOrFail($id);
        $image = $this->updatePhoto($sosialMediaOld);

        $data['icon'] = $image['url'];

        $result = $this->mainRepository->update($id, $data);

        if ($result) {
            if ($image['code'] == 3) {
                $this->deletePhoto($sosialMediaOld->icon);
            }
        } else {
            $this->deletePhoto($data['icon']);
        }

        return $result;
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
