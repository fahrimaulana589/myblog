<?php

namespace Models;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BlogTest extends TestCase
{
    /** @test */
    public function blogs_table_has_expected_column()
    {
        $result = Schema::hasColumns("blogs", [
            "name", "image", "date", "content", "comment"
        ]);

        $this->assertTrue($result);
    }

    /** @test */
    public function blogs_table_name_is_unique()
    {
        $this->expectException(QueryException::class);

        Blog::factory()->create([
            "name" => "blog masak code"
        ]);

        Blog::factory()->create([
            "name" => "blog masak code"
        ]);
    }

    /** @test */
    public function blogs_table_image_is_unique()
    {
        $this->expectException(QueryException::class);

        Blog::factory()->create([
            "image" => "blog masak code"
        ]);

        Blog::factory()->create([
            "image" => "blog masak code"
        ]);
    }

    /** @test */
    public function blogs_table_comment_is_unique()
    {
        $this->expectException(QueryException::class);

        Blog::factory()->create([
            "comment" => "blog masak code"
        ]);

        Blog::factory()->create([
            "comment" => "blog masak code"
        ]);
    }

    /** @test */
    public function blog_punya_satu_categori()
    {
        Category::factory(5)->create();

        $blog = Blog::factory()->create([
            "category_id" => 5
        ]);

        $result = $blog->category->exists();

        $this->assertTrue($result);
    }

    /** @test */
    public function blog_dapat_dibuat_jika_kategori_id_ada()
    {
        $category = Category::factory(5)->create()->first();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $this->assertDatabaseHas("blogs", $blog->toArray());
    }

    /** @test */
    public function blog_tidak_dapat_dibuat_jika_kategori_tidak_ada()
    {
        $this->expectException(QueryException::class);

        Category::factory(5)->create();

        $blog = Blog::factory()->create([
            "category_id" => 6
        ]);
    }

    /** @test */
    public function categori_tidak_bisa_dihapus_jika_blog_ada_yang_memiliki_idnya()
    {
        $this->expectException(QueryException::class);

        Category::factory(5)->create();

        $blog = Blog::factory()->create([
            "category_id" => 5
        ]);

        Category::find(5)->delete();
    }

    /** @test */
    public function blog_memiliki_banyak_tags()
    {
        Tag::factory(5)->create()->first();

        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $blog->tags()->attach([2, 4]);

        $tags = Blog::find($blog->id)->tags();

        $this->assertTrue($tags->count() == 2);
    }

    /** @test */
    public function blog_dapat_dibuat_jika_tag_id_ada_di_table_tags()
    {
        Tag::factory(5)->create();

        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $tags = Tag::all()->map(function ($val) {
            return $val->id;
        })->toArray();

        $blog->tags()->attach($tags);

        $tags = Blog::all()->first()->tags;

        $this->assertTrue($tags->count() == 5);
    }

    /** @test */
    public function blog_tidak_dapat_dibuat_jika_tag_id_tidak_ada_di_table_tags()
    {
        $this->expectException(QueryException::class);

        Tag::factory(5)->create();

        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $blog->tags()->attach([2, 9]);

    }

}
