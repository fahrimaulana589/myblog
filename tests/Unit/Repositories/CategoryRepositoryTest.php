<?php

namespace Tests\Unit\Repositories;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_jika_ambil_semua_category_maka_semua_category_akan_terambil()
    {
        Category::factory(5)->create();

        $service = app()->make(CategoryRepository::class);

        $categorys = $service->all();

        $this->assertDatabaseCount('categories',5);
        $this->assertTrue($categorys->count() == 5);
    }

    public function test_jika_ambil_category_dengan_id_maka_category_akan_diambil_sesui_dengan_id()
    {
        Category::factory(5)->create()->first()->id;

        $category_id = Category::factory()->create([
            'name' => 'php'
        ])->id;

        $service = app()->make(CategoryRepository::class);

        $category = $service->find($category_id);

        $this->assertTrue($category->name == 'php');
    }

    public function test_jika_ambil_category_dengan_id_tidak_ada_maka_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        Category::factory(5)->create()->first()->id;
        $category_id = Category::factory()->create([
            'name' => 'php'
        ])->id;

        $service = app()->make(CategoryRepository::class);

        $category = $service->findOrFail(122);

        $this->assertTrue($category->name == 'php');
    }

    public function test_jika_buat_category_maka_category_akan_dibuat_sesui_dengan_data()
    {
        $service = app()->make(CategoryRepository::class);

        $category = $service->create([
            'name' => 'php'
        ]);

        $this->assertDatabaseHas('categories',[
            'name' => 'php'
        ]);
    }

    public function test_jika_buat_category_nama_sudah_ada_maka_eror()
    {
        $this->expectException(QueryException::class);

        $service = app()->make(CategoryRepository::class);

        $service->create([
            'name' => 'php'
        ]);

        $service->create([
            'name' => 'php'
        ]);

    }

    public function test_jika_buat_category_nama_kosong_maka_eror()
    {
        $this->expectException(QueryException::class);

        $service = app()->make(CategoryRepository::class);

        $service->create([]);

    }

    public function test_jika_update_category_maka_category_akan_terupdate_sesui_dengan_data()
    {
        $category_id = Category::factory()->create([
            'name' => 'php'
        ])->id;

        $service = app()->make(CategoryRepository::class);

        $service->update($category_id,[
            'name' => 'java'
        ]);

        $this->assertDatabaseHas('categories',[
            'name' => 'java'
        ]);
    }

    public function test_jika_update_category_dengan_id_tidak_ada_maka_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $category_id = Category::factory()->create([
            'name' => 'php'
        ])->id;

        $service = app()->make(CategoryRepository::class);

        $service->update(121,[
            'name' => 'java'
        ]);
    }

    public function test_jika_update_category_dengan_nama_sudah_ada_maka_eror()
    {
        $this->expectException(QueryException::class);

        Category::factory()->create([
            'name' => 'java'
        ]);

        $category_id = Category::factory()->create([
            'name' => 'php'
        ])->id;

        $service = app()->make(CategoryRepository::class);

        $service->update($category_id,[
            'name' => 'java'
        ]);
    }

    public function test_jika_delete_category_dengan_id_category_akan_category_terhapus()
    {
        $service = app()->make(CategoryRepository::class);

        Category::factory(5)->create();

        $category = Category::factory()->create([
            'name' => 'java'
        ]);

        $service->delete($category->id);

        $this->assertDatabaseCount('categories',5);
        $this->assertDatabaseMissing('categories',[
            'name' => 'java'
        ]);
    }

    public function test_jika_delete_category_dengan_id_tidak_ada_maka_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $service = app()->make(CategoryRepository::class);

        Category::factory(5)->create();

        $category = Category::factory()->create([
            'name' => 'java'
        ]);

        $service->delete(1212);
    }
}
