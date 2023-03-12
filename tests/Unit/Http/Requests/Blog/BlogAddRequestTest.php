<?php

namespace Http\Requests\Blog;

use App\Http\Middleware\TrimStrings;
use App\Http\Requests\Blog\BlogAddRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BlogAddRequestTest extends TestCase
{

    public function test_jika_data_benar_maka_validasi_sukses()
    {
        $file = UploadedFile::fake()->image('image.jpg');

        $request = Request::create('/','POST',[
            'name' => 'php',
            'content' => 'asas asas asas',
            'date' => fake()->date,
            'comment' => 'sdsd sd sd sd',
        ],files: [
            'file' => $file
        ]);

        request()->request = $request;

        $requestApp = app()->make(BlogAddRequest::class);

        $request->validate($requestApp->rules());

        $this->assertTrue(True);
    }
}
