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

        $path_photo = $this->file('file_1');
        $path_file = $this->file('file_2');

        $data['photo'] = $path_photo;
        $data['file'] = $path_photo;

        return $this->mainRepository->change($data);
    }

    private function isExist()
    {
        $profile = $this->mainRepository->view();

        if ($profile == null) {
            $this->mainRepository->faker();
        }
    }

    private function file($index)
    {
        $oldPath = $this->mainRepository->view()->photo;

        if (request()->get($index) == null) {
            return $oldPath;
        } elseif (! isset(request()->get($index)->name)) {
            return $oldPath;
        }

        Storage::delete($oldPath);

        return request()->get($index)->store('files');
    }
}
