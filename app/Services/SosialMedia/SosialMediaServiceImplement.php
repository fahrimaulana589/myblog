<?php

namespace App\Services\SosialMedia;

use Illuminate\Support\Facades\Request;
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

    public function create($data)
    {
        $path = request()->get("file")->store("files");

        $data["icon"] = $path;

        return $this->mainRepository->create($data);
    }
}
