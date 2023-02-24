<?php

namespace Tests\Unit\Repositories;

use App\Models\Service;
use App\Repositories\Serv\ServRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class ServRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function ambil_semua_service()
    {
        Service::factory(5)->create();

        $ServRepository = app()->make(ServRepository::class);

        $service = $ServRepository->all();

        $this->assertTrue($service->count() == 5);
    }

    /** @test */
    public function ambil_detail_data_service_dengan_id()
    {
        $idService = Service::factory(5)->create()->first()->id;

        $ServRepository = app()->make(ServRepository::class);

        $Service = $ServRepository->findOrFail($idService);

        $this->assertTrue($Service->id == $idService);
    }

    /** @test */
    public function ambil_detail_data_service_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        Service::factory(5)->create()->first()->id;

        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->findOrFail(155);
    }

    /** @test */
    public function buat_data_service()
    {
        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->create([
            'name' => 'tweter',
            'icon' => fake()->imageUrl(),
            'summary' => 'test.com',
        ]);

        $this->assertDatabaseCount('services', 1);
    }

    /** @test */
    public function buat_data_duplikat_service_nama_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->create([
            'name' => 'tweter',
            'icon' => 'image1.jpg',
            'summary' => 'test1.com',
        ]);

        $ServRepository->create([
            'name' => 'tweter',
            'icon' => 'image2.jpg',
            'summary' => 'test2.com',
        ]);
    }

    /** @test */
    public function buat_data_duplikat_service_icon_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->create([
            'name' => 'tweter1',
            'icon' => 'image1.jpg',
            'summary' => 'test1.com',
        ]);

        $ServRepository->create([
            'name' => 'tweter2',
            'icon' => 'image1.jpg',
            'summary' => 'test2.com',
        ]);
    }

    /** @test */
    public function buat_data_kurang_service_nama_tidak_data_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->create([
            'icon' => 'image1.jpg',
            'summary' => 'test1.com',
        ]);
    }

    /** @test */
    public function buat_data_kurang_service_icon_tidak_data_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->create([
            'name' => 'tweter1',
            'summary' => 'test1.com',
        ]);
    }

    /** @test */
    public function buat_data_kurang_service_summary_tidak_data_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->create([
            'name' => 'tweter1',
            'icon' => 'image1.jpg',
        ]);
    }

    /** @test  */
    public function update_data_service_dengan_id()
    {
        $idSosialMedia = Service::factory(5)->create()->first()->id;

        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->update($idSosialMedia, [
            'name' => 'test',
            'icon' => 'image.png',
            'summary' => 'trwe.com',
        ]);

        $this->assertDatabaseHas('services', [
            'name' => 'test',
            'icon' => 'image.png',
            'summary' => 'trwe.com',
        ]);
    }

    /** @test  */
    public function update_data_service_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->update(6, [
            'name' => 'test',
            'icon' => 'image.png',
            'summary' => 'trwe.com',
        ]);
    }

    /** @test  */
    public function update_data_service_dengan_nama_sudak_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServRepository = app()->make(ServRepository::class);

        $data1 = Service::factory()->create([
            'name' => 'test',
            'icon' => 'image.png',
            'summary' => 'trwe.com',
        ]);

        $data2 = Service::factory()->create();

        $ServRepository->update($data2->id, [
            'name' => 'test',
        ]);
    }

    /** @test  */
    public function update_data_service_dengan_icon_sudak_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServRepository = app()->make(ServRepository::class);

        $data1 = Service::factory()->create([
            'name' => 'test',
            'icon' => 'image.png',
            'summary' => 'trwe.com',
        ]);

        $data2 = Service::factory()->create();

        $ServRepository->update($data2->id, [
            'icon' => 'image.png',
        ]);
    }

    /** @test */
    public function delete_data_service_dengan_id()
    {
        $sosialMedai = Service::factory()->create();

        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->delete($sosialMedai->id);

        $this->assertDatabaseCount('services', 0);
    }

    /** @test */
    public function delete_data_service_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $ServRepository = app()->make(ServRepository::class);

        $ServRepository->delete(3);
    }
}
