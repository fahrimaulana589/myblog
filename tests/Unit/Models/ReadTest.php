<?php

namespace Models;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Portofolio;
use App\Models\Read;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class ReadTest extends TestCase
{
    /** @test  */
    public function read_memiliki_kolum_yang_disetujui()
    {
        $response = \Schema::hasColumns("reads",[
            "count"
        ]);

        $this->assertTrue($response);
    }

    /** @test  */
    public function read_akan_terhapus_jika_blog_dihapus()
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

    /** @test  */
    public function read_akan_terhapus_jika_portofolio_dihapus()
    {
        $portofolio = Portofolio::factory()->create();

        $portofolio->read()->save(new Read());

        $portofolio = Portofolio::find($portofolio->id);
        $portofolio->delete();

        $this->assertDatabaseCount("reads",0);
    }

    /** @test  */
    public function read_tidak_bisa_dihapus_jika_masih_terhubung_keblog()
    {
        $this->expectException(QueryException::class);

        $category = Category::factory()->create();

        $blog = Blog::factory()->create([
            "category_id" => $category->id
        ]);

        $blog->read()->save(new Read());

        $read_id = Blog::find($blog->id)->read->id;
        $blog->read_id = $read_id;
        $blog->save();

        $read = Read::find($read_id);

        $read->delete();
    }

    /** @test  */
    public function read_tidak_bisa_dihapus_jika_masih_terhubung_keportofolio()
    {
        $this->expectException(QueryException::class);

        $portofolio = Portofolio::factory()->create();

        $portofolio->read()->save(new Read());

        $read_id = Portofolio::find($portofolio->id)->read->id;
        $portofolio->read_id = $read_id;
        $portofolio->save();

        $read = Read::find($read_id);

        $read->delete();
    }
}
