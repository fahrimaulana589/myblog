<?php

namespace App\Repositories\CurriculumVitae;

use App\Models\Profile;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\CurriculumVitae;

class CurriculumVitaeRepositoryImplement extends Eloquent implements CurriculumVitaeRepository{

    public $default_id = 1;
    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(CurriculumVitae $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function view()
    {
        return $this->model->find($this->default_id);
    }

    public function change(array $data)
    {
        return $this->model->find($this->default_id)->fill($data)->save();
    }

    public function faker()
    {
        return CurriculumVitae::factory()->create([
            'id' => $this->default_id,
        ]);
    }
}
