<?php

namespace App\Repositories\Tag;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Tag;

class TagRepositoryImplement extends Eloquent implements TagRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
