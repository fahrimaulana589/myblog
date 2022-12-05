<?php

namespace App\Repositories\Profile;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Profile;

class ProfileRepositoryImplement extends Eloquent implements ProfileRepository
{
    public $default_id = 1;
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Profile $model)
    {
        $this->model = $model;
    }

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
        return Profile::factory()->create([
            'id' => $this->default_id
        ]);
    }
}
