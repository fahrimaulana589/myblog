<?php

namespace App\Services\Skill;

use LaravelEasyRepository\Service;
use App\Repositories\Skill\SkillRepository;

class SkillServiceImplement extends Service implements SkillService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(SkillRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
