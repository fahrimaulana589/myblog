<?php

namespace App\Repositories\Contact;

use App\Models\CurriculumVitae;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Contact;

class ContactRepositoryImplement extends Eloquent implements ContactRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;
    public $default_id = 1;

    public function __construct(Contact $model)
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
        return Contact::factory()->create([
            'id' => $this->default_id,
        ]);
    }
}
