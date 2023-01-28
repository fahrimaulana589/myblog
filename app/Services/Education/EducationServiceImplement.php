<?php

namespace App\Services\Education;

use LaravelEasyRepository\Service;
use App\Repositories\Education\EducationRepository;

class EducationServiceImplement extends Service implements EducationService{

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
