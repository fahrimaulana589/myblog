<?php

namespace App\Services\Education;

use App\Repositories\Education\EducationRepository;
use LaravelEasyRepository\Service;

class EducationServiceImplement extends Service implements EducationService
{
    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(EducationRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
