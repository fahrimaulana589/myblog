<?php

namespace App\Repositories\Experience;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Experience;

class ExperienceRepositoryImplement extends Eloquent implements ExperienceRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Experience $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
