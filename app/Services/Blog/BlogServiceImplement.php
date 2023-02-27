<?php

namespace App\Services\Blog;

use LaravelEasyRepository\Service;
use App\Repositories\Blog\BlogRepository;

class BlogServiceImplement extends Service implements BlogService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(BlogRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
