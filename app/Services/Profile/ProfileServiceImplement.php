<?php

namespace App\Services\Profile;

use App\Repositories\Profile\ProfileRepository;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Service;

class ProfileServiceImplement extends Service implements ProfileService
{
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
        }

        Storage::delete($oldPath);

        return request()->get('file')->store('files');
    }
}
