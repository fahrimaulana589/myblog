<?php

namespace Services;

use App\Models\SocialMedia;
use App\Repositories\SosialMedia\SosialMediaRepository;
use App\Services\SosialMedia\SosialMediaService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
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

        $request = \Illuminate\Http\Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $data = $sosialMediaService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $this->assertDatabaseCount('social_medias', 1);
    }

    /** @test */
    public function buat_data_duplikat_sosial_media_nama_sama()
    {
        $this->expectException(QueryException::class);

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMediaRepository->create([
            'name' => 'tweter',
            'icon' => 'image1.jpg',
            'url' => 'test1.com',
        ]);

        $sosialMediaRepository->create([
            'name' => 'tweter',
            'icon' => 'image2.jpg',
            'url' => 'test2.com',
        ]);
    }

    /** @test */
    public function buat_data_duplikat_sosial_media_icon_sama()
    {
        $this->expectException(QueryException::class);

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMediaRepository->create([
            'name' => 'tweter1',
            'icon' => 'image1.jpg',
            'url' => 'test1.com',
        ]);

        $sosialMediaRepository->create([
            'name' => 'tweter2',
            'icon' => 'image1.jpg',
            'url' => 'test2.com',
        ]);
    }

    /** @test */
    public function buat_data_duplikat_sosial_media_url_sama()
    {
        $this->expectException(QueryException::class);

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMediaRepository->create([
            'name' => 'tweter1',
            'icon' => 'image1.jpg',
            'url' => 'test1.com',
        ]);

        $sosialMediaRepository->create([
            'name' => 'tweter2',
            'icon' => 'image2.jpg',
            'url' => 'test1.com',
        ]);
    }

    /** @test */
    public function update_data_sosial_media_dengan_id()
    {
        $idSosialMedia = SocialMedia::factory(5)->create()->first()->id;

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMediaRepository->update($idSosialMedia, [
            'name' => 'test',
            'icon' => 'image.png',
            'url' => 'trwe.com',
        ]);

        $this->assertDatabaseHas('social_medias', [
            'name' => 'test',
            'icon' => 'image.png',
            'url' => 'trwe.com',
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
    public function delete_data_sosial_media_dengan_id()
    {
        $sosialMedai = SocialMedia::factory()->create();

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMediaRepository->delete($sosialMedai->id);

        $this->assertDatabaseCount('social_medias', 0);
    }

    /** @test */
    public function delete_data_sosial_media_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMediaRepository->delete(3);
    }
}
