<?php

namespace Tests\Unit\Models;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TagTest extends TestCase
{
    /** @test */
    public function tags_table_has_expected_column()
    {
        $result = Schema::hasColumns('tags', [
            'name',
        ]);

        $this->assertTrue($result);
    }

    /** @test  */
    public function tags_table_name_column_is_unique()
    {
        $this->expectException(QueryException::class);

        Tag::create([
            'name' => 'hobi sehat',
        ]);

        Tag::create([
            'name' => 'hobi sehat',
        ]);
    }

    /** @test  */
    public function pivot_yang_menghubungkan_blog_dan_tag_akan_dihapus_jika_blog_dihapus()
    {
        Tag::factory(5)->create()->first();

        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            'category_id' => $category->id,
        ]);

        $tags = Tag::all()->map(function ($val) {
            return $val->id;
        })->toArray();
        $blog->tags()->attach($tags);

        Blog::find($blog->id)->delete();

        $pivot = DB::table('blog_tag')->get();

        $this->assertTrue($pivot->count() == 0);
    }

    /** @test  */
    public function pivot_yang_menghubungkan_blog_dan_tag_akan_dihapus_jika_tag_dihapus()
    {
        $tag = Tag::factory()->create()->first();

        $category = Category::factory()->create();

        $blog = Blog::factory(5)->create([
            'category_id' => $category->id,
        ]);

        $blogs = Blog::all()->map(function ($val) {
            return $val->id;
        })->toArray();
        $tag->blogs()->attach($blogs);

        Tag::find($tag->id)->delete();

        $pivot = DB::table('blog_tag')->get();

        $this->assertTrue($pivot->count() == 0);
    }
}
