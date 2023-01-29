<?php

namespace App\Services\Experience;

use App\Repositories\Education\EducationRepository;
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

    // Define your custom methods :)
}
