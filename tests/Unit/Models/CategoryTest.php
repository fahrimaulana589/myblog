<?php

namespace Tests\Unit\Models;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /** @test  */
    public function categories_table_has_expected_colum()
    {
        $result = Schema::hasColumns('categories', [
            'name',
        ]);

        $this->assertTrue($result);
    }

    /** @test  */
    public function categories_table_name_is_unique()
    {
        $this->expectException(QueryException::class);

        Category::factory()->create([
            'name' => 'baju',
        ]);

        Category::factory()->create([
            'name' => 'baju',
        ]);
    }

    /** @test */
    public function categori_tidak_bisa_dihapus_jika_blog_ada_yang_memiliki_idnya()
    {
        $this->expectException(QueryException::class);

        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            'category_id' => $category->id,
        ]);

        Category::find($category->id)->delete();
    }
}
