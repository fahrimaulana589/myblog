<?php

namespace App\Services\Profile;

use LaravelEasyRepository\Service;
use App\Repositories\Profile\ProfileRepository;

class ProfileServiceImplement extends Service implements ProfileService{
     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(ProfileRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function view()
    {
        $this->isExist();

        return $this->mainRepository->view();
    }

    public function change(array $data)
    {
        $this->isExist();

        return $this->mainRepository->change($data);
    }

    public function isExist()
    {
        $profile = $this->mainRepository->view();

        if($profile == null){
            $this->mainRepository->faker();
        }
    }

}
