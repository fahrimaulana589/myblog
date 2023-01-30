<?php

namespace App\Repositories\Skill;

use App\Models\Skill;
use LaravelEasyRepository\Implementations\Eloquent;

class SkillRepositoryImplement extends Eloquent implements SkillRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Skill $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
