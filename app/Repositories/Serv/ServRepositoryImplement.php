<?php

namespace App\Repositories\Serv;

use App\Models\Service;
use LaravelEasyRepository\Implementations\Eloquent;

class ServRepositoryImplement extends Eloquent implements ServRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
