<?php

namespace Models;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Read;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
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
    public function blog_lain_dapat_memiliki_kategori_sama()
    {
        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $blog2 = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $category = Category::find($category->id);

        $this->assertTrue($category->blogs()->count() == 2);
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
    public function blog_lain_dapat_memiliki_tag_yang_sama()
    {
        $tag = Tag::factory()->create()->first();

        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $blog2 = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $blog->tags()->attach([$tag->id]);
        $blog2->tags()->attach([$tag->id]);

        $tag = Tag::find($tag->id);

        $this->assertTrue($tag->blogs()->count() == 2);
    }

    /** @test  */
    public function blog_tidak_bisa_memiliki_tag_sama()
    {
        $this->expectException(QueryException::class);

        $tag = Tag::factory()->create()->first();

        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $blog->tags()->attach([$tag->id]);
        $blog->tags()->attach([$tag->id]);
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

    /** @test  */
    public function pivot_yang_menghubungkan_blog_dan_tag_akan_dihapus_jika_blog_dihapus()
    {
        Tag::factory(5)->create()->first();

        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $tags = Tag::all()->map(function ($val) {
            return $val->id;
        })->toArray();
        $blog->tags()->attach($tags);

        Blog::find($blog->id)->delete();

        $pivot = DB::table("blog_tag")->get();

        $this->assertTrue($pivot->count() == 0);
    }

    /** @test  */
    public function pivot_yang_menghubungkan_blog_dan_tag_akan_dihapus_jika_tag_dihapus()
    {
        $tag = Tag::factory()->create()->first();

        $category = Category::factory()->create();

        $blog = Blog::factory(5)->create([
            "category_id" => $category->id
        ]);

        $blogs = Blog::all()->map(function ($val) {
            return $val->id;
        })->toArray();
        $tag->blogs()->attach($blogs);

        Tag::find($tag->id)->delete();

        $pivot = DB::table("blog_tag")->get();

        $this->assertTrue($pivot->count() == 0);
    }

    /** @test */
    public function blog_memiliki_satu_read_untuk_setiap_blog()
    {
        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $blog->read()->save(new Read());

        $blog = Blog::find($blog->id);

        $this->assertTrue($blog->read->count == 1);
    }

    /** @test  */
    public function blog_tidak_bisa_memiliki_read_lebih_dari_satu()
    {
        $this->expectException(QueryException::class);

        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $blog->read()->save(new Read());
        $blog->read()->save(new Read());
    }

    /** @test  */
    public function cread_akan_terhapus_jika_blog_dihapus()
    {
        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $blog->read()->save(new Read());

        $blog = Blog::find($blog->id);
        $blog->delete();

        $this->assertDatabaseCount("reads",0);
    }
}
