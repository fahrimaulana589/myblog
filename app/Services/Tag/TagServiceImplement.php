<?php

namespace App\Services\Tag;

use LaravelEasyRepository\Service;
use App\Repositories\Tag\TagRepository;

class TagServiceImplement extends Service implements TagService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(TagRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function update($id, array $data)
    {
        $this->mainRepository->findOrFail($id);
        $result = $this->mainRepository->update($id, $data);

        return $result;
    }

    public function delete($id)
    {
        $this->mainRepository->findOrFail($id);
        $result = $this->mainRepository->delete($id);

        return $result;
    }
}
