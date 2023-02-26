<?php

namespace App\Services\CurriculumVitae;

use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Service;
use App\Repositories\CurriculumVitae\CurriculumVitaeRepository;

class CurriculumVitaeServiceImplement extends Service implements CurriculumVitaeService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(CurriculumVitaeRepository $mainRepository)
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

        $path = $this->photo();

        $data['photo'] = $path;

        return $this->mainRepository->change($data);
    }

    private function isExist()
    {
        $profile = $this->mainRepository->view();

        if ($profile == null) {
            $this->mainRepository->faker();
        }
    }

    private function photo()
    {
        $oldPath = $this->mainRepository->view()->photo;

        if (request()->get('file') == null) {
            return $oldPath;
        } elseif (! isset(request()->get('file')->name)) {
            return $oldPath;
        }

        Storage::delete($oldPath);

        return request()->get('file')->store('files');
    }
}
