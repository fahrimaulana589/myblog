<?php

namespace Tests\Unit\Models;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Portofolio;
use App\Models\Read;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PortofolioTest extends TestCase
{

    /** @test  */
    public function portofolio_memiliki_colom_yang_disetujui()
    {
        $result = Schema::hasColumns("blogs", [
            "name", "image", "content", "comment"
        ]);

        $this->assertTrue($result);

    }

    /** @test */
    public function portofolios_table_name_is_unique()
    {
        $this->expectException(QueryException::class);

        Portofolio::factory()->create([
            "name" => "blog masak code",
        ]);

        Portofolio::factory()->create([
            "name" => "blog masak code",
        ]);
    }

    /** @test */
    public function portofolios_table_image_is_unique()
    {
        $this->expectException(QueryException::class);

        Portofolio::factory()->create([
            "image" => "blog masak code",
        ]);

        Portofolio::factory()->create([
            "image" => "blog masak code",
        ]);
    }

    /** @test */
    public function portofolio_table_comment_is_unique()
    {
        $this->expectException(QueryException::class);

        Portofolio::factory()->create([
            "comment" => "blog masak code",
        ]);

        Portofolio::factory()->create([
            "comment" => "blog masak code",
        ]);
    }

    /** @test */
    public function portofolio_memiliki_satu_read_untuk_setiap_portofolio()
    {

        $portofolio = Portofolio::factory()->create();

        $portofolio->read()->save(new Read());

        $portofolio = Portofolio::find($portofolio->id);

        $this->assertTrue($portofolio->read->count == 1);
    }

    /** @test  */
    public function portofolio_tidak_bisa_memiliki_read_lebih_dari_satu()
    {
        $this->expectException(QueryException::class);

        $portofolio = Portofolio::factory()->create();

        $portofolio->read()->save(new Read());
        $portofolio->read()->save(new Read());

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
