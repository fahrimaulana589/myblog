<?php

namespace Tests\Unit\Http\Requests\Tag;

use App\Http\Requests\Tag\TagAddRequest;
use App\Http\Requests\Tag\TagDeleteRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class TagDeleteRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_validasi_suskes()
    {
        $tag = Tag::factory()->create();

        $request = Request::create('','POST',[
            'id' => $tag->id
        ]);

        request()->request = $request;

        $tag_delete_request = new TagDeleteRequest();

        $request->validate($tag_delete_request->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_id_tidak_ada()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('','POST',[
            'id' => 22
        ]);

        request()->request = $request;

        $tag_delete_request = new TagDeleteRequest();

        $request->validate($tag_delete_request->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_id_terpakai_blog()
    {
        $this->expectException(ValidationException::class);
        $this->expectErrorMessage('id tidak dapat dihapus');

        $tag = Tag::factory()->create();

        $category = Category::factory()->create();
        $blog = Blog::factory()->create([
            'category_id' => $category->id
        ]);
        $blog->tags()->save($tag);

        $request = Request::create('','POST',[
            'id' => $tag->id
        ]);

        request()->request = $request;

        $tag_delete_request = new TagDeleteRequest();

        $request->validate($tag_delete_request->rules());

        $this->assertTrue(true);
    }
}
