<?php

namespace App\Repositories\Portofolio;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Portofolio;

class PortofolioRepositoryImplement extends Eloquent implements PortofolioRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Portofolio $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
