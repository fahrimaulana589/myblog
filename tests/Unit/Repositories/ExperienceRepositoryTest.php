<?php

namespace Tests\Unit\Repositories;

use App\Models\Experience;
use App\Repositories\Experience\ExperienceRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class ExperienceRepositoryTest extends TestCase
{
    public function test_ambil_semua_experience()
    {
        Experience::factory(5)->create();

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experiences = $experienceRepository->all();

        $this->assertTrue($experiences->count() == 5);
    }

    public function test_ambil_detail_experience_dengan_id()
    {
        $experiences = Experience::factory(5)->create();

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experience = $experienceRepository->find($experiences->first()->id);

        $this->assertTrue($experience->id == $experiences->first()->id);
    }

    public function test_ambil_detail_experience_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        Experience::factory(5)->create();

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experienceRepository->findOrFail(121);
    }

    public function test_buat_data_experience()
    {
        $experienceRepository = app()->make(ExperienceRepository::class);

        $experience = $experienceRepository->create([
            'name' => 'test',
            'summary' => 'test',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        $this->assertDatabaseCount('experiences', 1);
    }

    public function test_buat_data_experience_dengan_nama_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $experienceRepository = app()->make(ExperienceRepository::class);

        $nama = 'php';

        $experience = $experienceRepository->create([
            'name' => 'test',
            'summary' => 'test',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        $experience = $experienceRepository->create([
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_buat_data_experience_dengan_nama_tidak_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experience = $experienceRepository->create([
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_buat_data_experience_dengan_summary_tidak_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experience = $experienceRepository->create([
            'name' => 'test',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_buat_data_experience_dengan_awal_tidak_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experience = $experienceRepository->create([
            'name' => 'test',
            'summary' => 'test2',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }
    public function test_buat_data_experience_dengan_akhir_tidak_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experience = $experienceRepository->create([
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_update_data_experience_dengan_id()
    {
        $idExperience = Experience::factory(5)->create()->first()->id;

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experience = $experienceRepository->update($idExperience, [
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        $this->assertDatabaseHas('experiences', [
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_update_data_experience_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $idExperience = Experience::factory(5)->create()->first()->id;

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experience = $experienceRepository->update(121, [
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_update_data_experience_dengan_nama_sudah_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $data1 = Experience::factory()->create([
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
        $data2 = Experience::factory()->create();

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experience = $experienceRepository->update($data2->id, [
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_update_data_experience_dengan_icon_sudah_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $data1 = Experience::factory()->create([
            'icon' => 'teasst.jpg',
        ]);
        $data2 = Experience::factory()->create();

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experience = $experienceRepository->update($data2->id, [
            'icon' => 'teasst.jpg',
        ]);
    }

    public function test_delete_experience_dari_id()
    {
        $experience = Experience::factory()->create();

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experienceRepository->delete($experience->id);

        $this->assertDatabaseCount('experiences', 0);
    }

    public function test_delete_experience_dari_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experienceRepository->delete(121212);

        $this->assertDatabaseCount('experiences', 0);
    }
}
