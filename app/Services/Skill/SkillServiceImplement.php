<?php

namespace App\Services\Skill;

use App\Repositories\Skill\SkillRepository;
use App\Traits\UploadFile;
use LaravelEasyRepository\Service;

class SkillServiceImplement extends Service implements SkillService
{
    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    use UploadFile;

    public function __construct(SkillRepository $mainRepository)
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
        $skillOld = $this->mainRepository->findOrFail($id);
        $image = $this->updatePhoto($skillOld);

        $data['icon'] = $image['url'];

        $result = $this->mainRepository->update($id, $data);

        if ($result) {
            if ($image['code'] == 3) {
                $this->deletePhoto($skillOld->icon);
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
