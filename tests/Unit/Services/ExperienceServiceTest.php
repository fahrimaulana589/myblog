<?php

namespace Tests\Unit\Services;

use App\Models\Experience;
use App\Repositories\Experience\ExperienceRepository;
use App\Services\Experience\ExperienceService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Tests\TestCase;

class ExperienceServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function ambil_semua_experience()
    {
        Experience::factory(5)->create();

        $experienceService = app()->make(ExperienceService::class);

        $experiences = $experienceService->all();

        $this->assertTrue($experiences->count() == 5);
    }

    /** @test */
    public function ambil_detail_data_experience_dengan_id()
    {
        $idExperience = Experience::factory(5)->create()->first()->id;

        $experienceService = app()->make(ExperienceService::class);

        $socialMedia = $experienceService->findOrFail($idExperience);

        $this->assertTrue($socialMedia->id == $idExperience);
    }

    /** @test */
    public function ambil_detail_data_experience_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        Experience::factory(5)->create()->first()->id;

        $experienceService = app()->make(ExperienceService::class);

        $experienceService->findOrFail(155);
    }

    /** @test */
    public function buat_data_experience()
    {
        $experienceService = app()->make(ExperienceService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'test',
            'summary' => 'test2',
            'date' => '2020-06-01 00:00:00',
        ]);

        request()->request = $request;

        $experienceService->create($request->all());

        $this->assertDatabaseCount('experiences', 1);
    }

    /** @test */
    public function buat_data_duplikat_experience_nama_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $experienceService = app()->make(ExperienceService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'test',
            'summary' => 'test',
            'date' => '2020-06-01 00:00:01',
        ]);

        $request2 = Request::create('/', 'POST', [
            'name' => 'test',
            'summary' => 'test2',
            'date' => '2020-06-01 00:00:02',
        ]);

        request()->request = $request;
        $experienceService->create($request->all());

        request()->request = $request2;
        $experienceService->create($request2->all());
    }

    /** @test */
    public function buat_data_experience_tanpa_nama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $experienceService = app()->make(ExperienceService::class);

        $request = Request::create('/', 'POST', [
            'summary' => 'test2',
            'date' => '2020-06-01 00:00:02',
        ]);

        request()->request = $request;

        $data = $experienceService->create($request->all());

    }

    /** @test */
    public function buat_data_experience_tanpa_summary_akan_eror()
    {
        $this->expectException(QueryException::class);

        $experienceService = app()->make(ExperienceService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'test',
            'date' => '2020-06-01 00:00:02',
        ]);

        request()->request = $request;

        $experienceService->create($request->all());

    }

    /** @test */
    public function buat_data_experience_tanpa_date_akan_eror()
    {
        $this->expectException(QueryException::class);

        $experienceService = app()->make(ExperienceService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'test',
            'summary' => 'test2',
        ]);

        request()->request = $request;

        $experienceService->create($request->all());

    }

    /** @test */
    public function update_data_experience_dengan_id()
    {
        $experience = Experience::factory(5)->create()->first();

        $experienceService = app()->make(ExperienceService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'test',
            'summary' => 'test2',
            'date' => '2020-06-01',
        ]);

        request()->request = $request;

        $experienceService->update($experience->id, $request->all());

        $this->assertDatabaseHas('experiences', [
            'name' => 'test',
            'summary' => 'test2',
            'date' => '2020-06-01',
        ]);
    }

    /** @test */
    public function update_data_experience_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        $experienceRepository = app()->make(ExperienceRepository::class);

        $experienceRepository->update(6, [
            'name' => 'test',
            'summary' => 'test2',
            'date' => '2020-06-01 00:00:02',
        ]);
    }

    /** @test */
    public function update_data_experience_dengan_nama_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        Experience::factory()->create([
            'name' => "popo"
        ]);
        $experience = Experience::factory()->create();

        $experienceService = app()->make(ExperienceService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'popo',
            'summary' => 'test2',
            'date' => '2020-06-01',
        ]);

        request()->request = $request;

        $experienceService->update($experience->id, $request->all());
    }

    /** @test */
    public function delete_data_experience_dengan_id()
    {
        $sosialMedai = Experience::factory()->create();

        $experienceService = app()->make(ExperienceService::class);

        $experienceService->delete($sosialMedai->id);

        $this->assertDatabaseCount('experiences', 0);
    }

    /** @test */
    public function delete_data_experience_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $experienceService = app()->make(ExperienceService::class);

        $experienceService->delete(3);
    }
}
