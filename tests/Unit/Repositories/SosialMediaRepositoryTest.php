<?php

namespace Repositories;

use App\Models\SocialMedia;
use App\Repositories\SosialMedia\SosialMediaRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class SosialMediaRepositoryTest extends TestCase
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

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMedias = $sosialMediaRepository->all();

        $this->assertTrue($sosialMedias->count() == 5);
    }

    /** @test */
    public function ambil_detail_data_sosial_media_dengan_id()
    {
        $idSocialMedia = SocialMedia::factory(5)->create()->first()->id;

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $socialMedia = $sosialMediaRepository->findOrFail($idSocialMedia);

        $this->assertTrue($socialMedia->id == $idSocialMedia);
    }

    /** @test */
    public function ambil_detail_data_sosial_media_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        SocialMedia::factory(5)->create()->first()->id;

        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMediaRepository->findOrFail(155);
    }

    public function buat_data_sosial_media()
    {
        $sosialMediaRepository = app()->make(SosialMediaRepository::class);

        $sosialMediaRepository->create([
            'name' => 'tweter',
            'icon' => fake()->imageUrl(),
            'url' => 'test.com',
        ]);

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

    /** @test  */
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

    /** @test  */
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
