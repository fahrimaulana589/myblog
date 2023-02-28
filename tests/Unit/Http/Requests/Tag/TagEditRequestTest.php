<?php

namespace Tests\Unit\Http\Requests\Tag;

use App\Http\Requests\Tag\TagAddRequest;
use App\Http\Requests\Tag\TagEditRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class TagEditRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_validasi_sukses()
    {
        $tag = Tag::factory()->create();

        $request = Request::create('','POST',[
            'id' => $tag->id,
            'name' => 'makanan'
        ]);

        request()->request = $request;

        $tag_edit_request = new TagEditRequest();

        $request->validate($tag_edit_request->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_sukses_update_nama_sama()
    {
        $tag = Tag::factory()->create([
            'name' => 'makanan'
        ]);

        $request = Request::create('','POST',[
            'id' => $tag->id,
            'name' => 'makanan'
        ]);

        request()->request = $request;

        $tag_edit_request = new TagEditRequest();

        $request->validate($tag_edit_request->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_sudah_ada()
    {
        $this->expectException(ValidationException::class);

        $tag = Tag::factory()->create();

        Tag::factory()->create([
            'name' => 'makanan'
        ]);

        $request = Request::create('','POST',[
            'id' => $tag->id,
            'name' => 'makanan'
        ]);

        request()->request = $request;

        $tag_edit_request = new TagEditRequest();

        $request->validate($tag_edit_request->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_kososng()
    {
        $this->expectException(ValidationException::class);

        $tag = Tag::factory()->create();

        $request = Request::create('','POST',[
            'id' => $tag->id,
        ]);

        request()->request = $request;

        $tag_edit_request = new TagEditRequest();

        $request->validate($tag_edit_request->rules());

        $this->assertTrue(true);
    }
}
