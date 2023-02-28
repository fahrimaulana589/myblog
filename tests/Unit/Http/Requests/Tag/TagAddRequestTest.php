<?php

namespace Tests\Unit\Http\Requests\Tag;


use App\Http\Requests\Tag\TagAddRequest;
use App\Models\Tag;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Illuminate\Http\Request;

class TagAddRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_validasi_sukses()
    {
        $request = Request::create('','POST',[
            'name' => 'makanan'
        ]);

        request()->request = $request;

        $tag_add_request = new TagAddRequest();

        $request->validate($tag_add_request->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_ksosng()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('','POST',[
            'name' => ''
        ]);

        request()->request = $request;

        $tag_add_request = new TagAddRequest();

        $request->validate($tag_add_request->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_sudah_ada()
    {
        $this->expectException(ValidationException::class);

        Tag::factory()->create([
           'name' => 'makanan'
        ]);

        $request = Request::create('','POST',[
            'name' => 'makanan'
        ]);

        request()->request = $request;

        $tag_add_request = new TagAddRequest();

        $request->validate($tag_add_request->rules());

        $this->assertTrue(true);
    }
}
