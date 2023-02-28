<?php

namespace App\Services\Experience;

use App\Repositories\Experience\ExperienceRepository;
use LaravelEasyRepository\Service;

class ExperienceServiceImplement extends Service implements ExperienceService
{
    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(ExperienceRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function update($id, array $data)
    {
        $this->mainRepository->findOrFail($id);
        $result = $this->mainRepository->update($id, $data);

        return $result;
    }

    public function delete($id)
    {
        $this->mainRepository->findOrFail($id);
        $result = $this->mainRepository->delete($id);

        return $result;
    }
}
