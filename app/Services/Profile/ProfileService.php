<?php

namespace App\Services\Profile;

use LaravelEasyRepository\BaseService;

interface ProfileService extends BaseService{

    // Write something awesome :)

    public function view();

    public function change(array $data);
}
