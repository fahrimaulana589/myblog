<?php

namespace App\Repositories\Profile;

use LaravelEasyRepository\Repository;

interface ProfileRepository extends Repository{

    // Write something awesome :)
    public function faker();

    public function view();

    public function change(array $data);
}
