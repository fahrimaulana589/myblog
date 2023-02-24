<?php

namespace App\Services\Serv;

use App\Repositories\Serv\ServRepository;
use App\Traits\UploadFile;
use LaravelEasyRepository\Service;

class ServServiceImplement extends Service implements ServService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    use UploadFile;

    public function __construct(ServRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function create($data)
    {
        $data['icon'] = $this->getPhoto();

        return $this->mainRepository->create($data);
    }

    public function update($id, array $data)
    {
        $olddata = $this->mainRepository->findOrFail($id);
        $image = $this->updatePhoto($olddata);

        $data['icon'] = $image['url'];

        $result = $this->mainRepository->update($id, $data);

        if ($result) {
            if ($image['code'] == 3) {
                $this->deletePhoto($olddata->icon);
            }
        } else {
            $this->deletePhoto($data['icon']);
        }

        return $result;
    }

    public function delete($id)
    {
        $skill = $this->mainRepository->findOrFail($id);
        $result = $this->mainRepository->delete($id);

        if ($result) {
            $this->deletePhoto($skill->icon);
        }

        return $result;
    }

}
