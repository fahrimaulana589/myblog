<?php

namespace App\Repositories\Education;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Education;

class EducationRepositoryImplement extends Eloquent implements EducationRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Education $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
