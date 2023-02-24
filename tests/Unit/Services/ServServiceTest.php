<?php

namespace Tests\Unit\Services;

use App\Models\Service;
use App\Repositories\SosialMedia\SosialMediaRepository;
use App\Services\Serv\ServService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServServiceTest extends TestCase
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

        $ServService = app()->make(ServService::class);

        $service = $ServService->all();

        $this->assertTrue($service->count() == 5);
    }

    /** @test */
    public function ambil_detail_data_service_dengan_id()
    {
        $idService = Service::factory(5)->create()->first()->id;

        $ServService = app()->make(ServService::class);

        $Service = $ServService->findOrFail($idService);

        $this->assertTrue($Service->id == $idService);
    }

    /** @test */
    public function ambil_detail_data_service_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        Service::factory(5)->create()->first()->id;

        $ServService = app()->make(ServService::class);

        $ServService->findOrFail(155);
    }

    /** @test */
    public function buat_data_service()
    {
        $ServService = app()->make(ServService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'summary' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $data = $ServService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);

        $this->assertDatabaseCount('services', 1);
    }

    /** @test */
    public function buat_data_service_tanpa_gambar()
    {
        $ServService = app()->make(ServService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'summary' => 'test.com',
        ]);

        request()->request = $request;

        $data = $ServService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);

        $this->assertDatabaseCount('services', 1);
    }

    /** @test */
    public function buat_data_service_gambar_bernilai_bukan_file()
    {
        $ServService = app()->make(ServService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'summary' => 'test.com',
            'file' => 'tset',
        ]);

        request()->request = $request;

        $data = $ServService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);

        $this->assertDatabaseCount('services', 1);
    }

    /** @test */
    public function buat_data_duplikat_service_nama_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServService = app()->make(ServService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');
        $file2 = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'summary' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        $request2 = Request::create('/', 'POST', [
            'name' => 'halo',
            'summary' => 'test.com',
        ], files: [
            'file' => $file2,
        ]);

        request()->request = $request;
        $ServService->create($request->all());

        request()->request = $request2;
        $ServService->create($request2->all());
    }

    /** @test */
    public function buat_data_duplikat_service_icon_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServService = app()->make(ServService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'summary' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        $request2 = Request::create('/', 'POST', [
            'name' => 'halo2',
            'summary' => 'test2.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $ServService->create($request->all());
        $ServService->create($request2->all());
    }

    /** @test */
    public function buat_data_service_tanpa_nama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServService = app()->make(ServService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'summary' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $data = $ServService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);

        $this->assertDatabaseCount('services', 1);
    }

    /** @test */
    public function buat_data_service_tanpa_array_akan_eror()
    {
        $this->expectException(QueryException::class);

        $ServService = app()->make(ServService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $data = $ServService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);
    }

    /** @test */
    public function update_data_service_dengan_id()
    {
        $sosialMedia = Service::factory(5)->create()->first();

        $ServService = app()->make(ServService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'summary' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $ServService->update($sosialMedia->id, $request->all());

        $newSosialMedia = $ServService->findOrFail($sosialMedia->id);

        Storage::assertMissing($sosialMedia->icon);
        Storage::assertExists($newSosialMedia->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 5);

        $this->assertDatabaseHas('services', [
            'name' => 'halo',
            'icon' => $newSosialMedia->icon,
            'summary' => 'test.com',
        ]);
    }

    /** @test */
    public function update_data_service_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMediaRepository->update(6, [
            'name' => 'test',
            'icon' => 'image.png',
            'summary' => 'trwe.com',
        ]);
    }

    /** @test */
    public function update_data_service_dengan_nama_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        Service::factory()->create([
            'name' => 'halo',
            'summary' => 'test.com',
        ]);

        $sosialMedia = Service::factory()->create();

        $ServService = app()->make(ServService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'summary' => 'test.com2',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $ServService->update($sosialMedia->id, $request->all());
    }

    /** @test */
    public function update_data_service_dengan_gambar()
    {
        $sosialMedia = Service::factory(5)->create()->first();

        $ServService = app()->make(ServService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'summary' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $ServService->update($sosialMedia->id, $request->all());

        $newSosialMedia = $ServService->findOrFail($sosialMedia->id);

        Storage::assertMissing($sosialMedia->icon);
        Storage::assertExists($newSosialMedia->icon);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 5);

        $this->assertDatabaseHas('services', [
            'name' => 'halo',
            'icon' => $newSosialMedia->icon,
            'summary' => 'test.com',
        ]);
    }

    /** @test */
    public function update_data_service_dengan_gambar_tidak_ada()
    {
        $sosialMedia = Service::factory(5)->create()->first();

        $ServService = app()->make(ServService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'summary' => 'test.com',
        ]);

        request()->request = $request;

        $ServService->update($sosialMedia->id, $request->all());

        $newSosialMedia = $ServService->findOrFail($sosialMedia->id);

        Storage::assertExists($newSosialMedia->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 5);

        $this->assertDatabaseHas('services', [
            'name' => 'halo',
            'icon' => $newSosialMedia->icon,
            'summary' => 'test.com',
        ]);
    }

    /** @test */
    public function delete_data_service_dengan_id()
    {
        $sosialMedai = Service::factory()->create();

        $ServService = app()->make(ServService::class);

        $ServService->delete($sosialMedai->id);

        Storage::assertMissing($sosialMedai->icon);

        $this->assertDatabaseCount('services', 0);
    }

    /** @test */
    public function delete_data_service_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $ServService = app()->make(ServService::class);

        $ServService->delete(3);
    }
}
