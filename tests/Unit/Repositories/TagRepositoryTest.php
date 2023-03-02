<?php

namespace Tests\Unit\Repositories;

use App\Models\Tag;
use App\Repositories\Tag\TagRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;
class TagRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_jika_ambil_semua_tag_maka_semua_tag_akan_terambil()
    {
        Tag::factory(5)->create();

        $service = app()->make(TagRepository::class);

        $tags = $service->all();

        $this->assertDatabaseCount('tags',5);
        $this->assertTrue($tags->count() == 5);
    }

    public function test_jika_ambil_tag_dengan_id_maka_tag_akan_diambil_sesui_dengan_id()
    {
        Tag::factory(5)->create()->first()->id;

        $tag_id = Tag::factory()->create([
            'name' => 'php'
        ])->id;

        $service = app()->make(TagRepository::class);

        $tag = $service->find($tag_id);

        $this->assertTrue($tag->name == 'php');
    }

    public function test_jika_ambil_tag_dengan_id_tidak_ada_maka_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        Tag::factory(5)->create()->first()->id;
        $tag_id = Tag::factory()->create([
            'name' => 'php'
        ])->id;

        $service = app()->make(TagRepository::class);

        $tag = $service->findOrFail(122);

        $this->assertTrue($tag->name == 'php');
    }

    public function test_jika_buat_tag_maka_tag_akan_dibuat_sesui_dengan_data()
    {
        $service = app()->make(TagRepository::class);

        $tag = $service->create([
            'name' => 'php'
        ]);

        $this->assertDatabaseHas('tags',[
            'name' => 'php'
        ]);
    }

    public function test_jika_buat_tag_nama_sudah_ada_maka_eror()
    {
        $this->expectException(QueryException::class);

        $service = app()->make(TagRepository::class);

        $service->create([
            'name' => 'php'
        ]);

        $service->create([
            'name' => 'php'
        ]);

    }

    public function test_jika_buat_tag_nama_kosong_maka_eror()
    {
        $this->expectException(QueryException::class);

        $service = app()->make(TagRepository::class);

        $service->create([]);

    }

    public function test_jika_update_tag_maka_tag_akan_terupdate_sesui_dengan_data()
    {
        $tag_id = Tag::factory()->create([
            'name' => 'php'
        ])->id;

        $service = app()->make(TagRepository::class);

        $service->update($tag_id,[
            'name' => 'java'
        ]);

        $this->assertDatabaseHas('tags',[
           'name' => 'java'
        ]);
    }

    public function test_jika_update_tag_dengan_id_tidak_ada_maka_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $tag_id = Tag::factory()->create([
            'name' => 'php'
        ])->id;

        $service = app()->make(TagRepository::class);

        $service->update(121,[
            'name' => 'java'
        ]);
    }

    public function test_jika_update_tag_dengan_nama_sudah_ada_maka_eror()
    {
        $this->expectException(QueryException::class);

        Tag::factory()->create([
           'name' => 'java'
        ]);

        $tag_id = Tag::factory()->create([
            'name' => 'php'
        ])->id;

        $service = app()->make(TagRepository::class);

        $service->update($tag_id,[
            'name' => 'java'
        ]);
    }

    public function test_jika_delete_tag_dengan_id_tag_akan_tag_terhapus()
    {
        $service = app()->make(TagRepository::class);

        Tag::factory(5)->create();

        $tag = Tag::factory()->create([
            'name' => 'java'
        ]);

        $service->delete($tag->id);

        $this->assertDatabaseCount('tags',5);
        $this->assertDatabaseMissing('tags',[
            'name' => 'java'
        ]);
    }

    public function test_jika_delete_tag_dengan_id_tidak_ada_maka_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $service = app()->make(TagRepository::class);

        Tag::factory(5)->create();

        $tag = Tag::factory()->create([
            'name' => 'java'
        ]);

        $service->delete(1212);
    }
}
