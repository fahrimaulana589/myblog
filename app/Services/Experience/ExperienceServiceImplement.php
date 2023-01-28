<?php

namespace App\Services\Experience;

use LaravelEasyRepository\Service;
use App\Repositories\Experience\ExperienceRepository;

class ExperienceServiceImplement extends Service implements ExperienceService{

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
