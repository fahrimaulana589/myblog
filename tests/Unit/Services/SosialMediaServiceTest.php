<?php

namespace Services;

use App\Models\SocialMedia;
use App\Repositories\SosialMedia\SosialMediaRepository;
use App\Services\SosialMedia\SosialMediaService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SosialMediaServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function ambil_semua_sosial_media()
    {
        SocialMedia::factory(5)->create();

        $sosialMediaService = app()->make(SosialMediaService::class);

        $sosialMedias = $sosialMediaService->all();

        $this->assertTrue($sosialMedias->count() == 5);
    }

    /** @test */
    public function ambil_detail_data_sosial_media_dengan_id()
    {
        $idSocialMedia = SocialMedia::factory(5)->create()->first()->id;

        $sosialMediaService = app()->make(SosialMediaService::class);

        $socialMedia = $sosialMediaService->findOrFail($idSocialMedia);

        $this->assertTrue($socialMedia->id == $idSocialMedia);
    }

    /** @test */
    public function ambil_detail_data_sosial_media_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        SocialMedia::factory(5)->create()->first()->id;

        $sosialMediaService = app()->make(SosialMediaService::class);

        $sosialMediaService->findOrFail(155);
    }

    /** @test */
    public function buat_data_sosial_media()
    {
        $sosialMediaService = app()->make(SosialMediaService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $data = $sosialMediaService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);


        $this->assertDatabaseCount('social_medias', 1);
    }

    /** @test */
    public function buat_data_sosial_media_tanpa_gambar()
    {
        $sosialMediaService = app()->make(SosialMediaService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ]);

        request()->request = $request;

        $data = $sosialMediaService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);

        $this->assertDatabaseCount('social_medias', 1);
    }

    /** @test */
    public function buat_data_sosial_media_gambar_bernilai_bukan_file()
    {
        $sosialMediaService = app()->make(SosialMediaService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
            'file' => 'tset',
        ]);

        request()->request = $request;

        $data = $sosialMediaService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);

        $this->assertDatabaseCount('social_medias', 1);
    }

    /** @test */
    public function buat_data_duplikat_sosial_media_nama_sama()
    {
        $this->expectException(QueryException::class);

        $sosialMediaService = app()->make(SosialMediaService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');
        $file2 = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        $request2 = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ], files: [
            'file' => $file2,
        ]);

        request()->request = $request;
        $sosialMediaService->create($request->all());

        request()->request = $request2;
        $sosialMediaService->create($request2->all());
    }

    /** @test */
    public function buat_data_duplikat_sosial_media_icon_sama()
    {
        $this->expectException(QueryException::class);

        $sosialMediaService = app()->make(SosialMediaService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        $request2 = Request::create('/', 'POST', [
            'name' => 'halo2',
            'url' => 'test2.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $sosialMediaService->create($request->all());
        $sosialMediaService->create($request2->all());
    }

    /** @test */
    public function buat_data_duplikat_sosial_media_url_sama()
    {
        $this->expectException(QueryException::class);

        $sosialMediaService = app()->make(SosialMediaService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');
        $file2 = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        $request2 = Request::create('/', 'POST', [
            'name' => 'halo2',
            'url' => 'test.com',
        ], files: [
            'file' => $file2,
        ]);

        request()->request = $request;
        $sosialMediaService->create($request->all());

        request()->request = $request2;
        $sosialMediaService->create($request2->all());
    }

    /** @test */
    public function buat_data_sosial_media_tanpa_nama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $sosialMediaService = app()->make(SosialMediaService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'url' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $data = $sosialMediaService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);

        $this->assertDatabaseCount('social_medias', 1);
    }

    /** @test */
    public function buat_data_sosial_media_tanpa_url_akan_eror()
    {
        $this->expectException(QueryException::class);

        $sosialMediaService = app()->make(SosialMediaService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $data = $sosialMediaService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);
    }

    /** @test */
    public function update_data_sosial_media_dengan_id()
    {
        $sosialMedia = SocialMedia::factory(5)->create()->first();

        $sosialMediaService = app()->make(SosialMediaService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $sosialMediaService->update($sosialMedia->id, $request->all());

        $newSosialMedia = $sosialMediaService->findOrFail($sosialMedia->id);

        Storage::assertMissing($sosialMedia->icon);
        Storage::assertExists($newSosialMedia->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 5);

        $this->assertDatabaseHas('social_medias', [
            'name' => 'halo',
            'icon' => $newSosialMedia->icon,
            'url' => 'test.com',
        ]);
    }

    /** @test */
    public function update_data_sosial_media_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMediaRepository->update(6, [
            'name' => 'test',
            'icon' => 'image.png',
            'url' => 'trwe.com',
        ]);
    }

    /** @test */
    public function update_data_sosial_media_dengan_gambar()
    {
        $sosialMedia = SocialMedia::factory(5)->create()->first();

        $sosialMediaService = app()->make(SosialMediaService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $sosialMediaService->update($sosialMedia->id, $request->all());

        $newSosialMedia = $sosialMediaService->findOrFail($sosialMedia->id);

        Storage::assertMissing($sosialMedia->icon);
        Storage::assertExists($newSosialMedia->icon);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 5);

        $this->assertDatabaseHas('social_medias', [
            'name' => 'halo',
            'icon' => $newSosialMedia->icon,
            'url' => 'test.com',
        ]);
    }

    /** @test */
    public function update_data_sosial_media_dengan_gambar_tidak_ada()
    {
        $sosialMedia = SocialMedia::factory(5)->create()->first();

        $sosialMediaService = app()->make(SosialMediaService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ]);

        request()->request = $request;

        $sosialMediaService->update($sosialMedia->id, $request->all());

        $newSosialMedia = $sosialMediaService->findOrFail($sosialMedia->id);

        Storage::assertExists($newSosialMedia->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 5);

        $this->assertDatabaseHas('social_medias', [
            'name' => 'halo',
            'icon' => $newSosialMedia->icon,
            'url' => 'test.com',
        ]);
    }

    /** @test */
    public function delete_data_sosial_media_dengan_id()
    {
        $sosialMedai = SocialMedia::factory()->create();

        $sosialMediaService = app()->make(SosialMediaService::class);

        $sosialMediaService->delete($sosialMedai->id);

        Storage::assertMissing($sosialMedai->icon);

        $this->assertDatabaseCount('social_medias', 0);
    }

    /** @test */
    public function delete_data_sosial_media_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        $sosialMediaService = app()->make(SosialMediaService::class);

        $sosialMediaService->delete(3);
    }
}
