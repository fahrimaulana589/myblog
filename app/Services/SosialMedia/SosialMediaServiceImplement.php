<?php

namespace App\Services\SosialMedia;

use LaravelEasyRepository\Service;
use App\Repositories\SosialMedia\SosialMediaRepository;

class SosialMediaServiceImplement extends Service implements SosialMediaService{

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
}
