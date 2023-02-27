<?php

namespace App\Services\Contact;

use LaravelEasyRepository\Service;
use App\Repositories\Contact\ContactRepository;

class ContactServiceImplement extends Service implements ContactService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(ContactRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
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

    private function isExist()
    {
        $profile = $this->mainRepository->view();

        if ($profile == null) {
            $this->mainRepository->faker();
        }
    }
}
