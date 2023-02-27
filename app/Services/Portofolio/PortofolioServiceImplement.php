<?php

namespace App\Services\Portofolio;

use LaravelEasyRepository\Service;
use App\Repositories\Portofolio\PortofolioRepository;

class PortofolioServiceImplement extends Service implements PortofolioService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(PortofolioRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
