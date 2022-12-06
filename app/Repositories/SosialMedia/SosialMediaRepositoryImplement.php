<?php

namespace App\Repositories\SosialMedia;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\SosialMedia;

class SosialMediaRepositoryImplement extends Eloquent implements SosialMediaRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(SosialMedia $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
