<?php

namespace Tests\Unit\Services;

use App\Models\Education;
use App\Repositories\Education\EducationRepository;
use App\Services\Education\EducationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Tests\TestCase;

class EducationServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function ambil_semua_education()
    {
        Education::factory(5)->create();

        $educationService = app()->make(EducationService::class);

        $educations = $educationService->all();

        $this->assertTrue($educations->count() == 5);
    }

    /** @test */
    public function ambil_detail_data_education_dengan_id()
    {
        $idEducation = Education::factory(5)->create()->first()->id;

        $educationService = app()->make(EducationService::class);

        $socialMedia = $educationService->findOrFail($idEducation);

        $this->assertTrue($socialMedia->id == $idEducation);
    }

    /** @test */
    public function ambil_detail_data_education_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        Education::factory(5)->create()->first()->id;

        $educationService = app()->make(EducationService::class);

        $educationService->findOrFail(155);
    }

    /** @test */
    public function buat_data_education()
    {
        $educationService = app()->make(EducationService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'test',
            'summary' => 'test2',
            'date' => '2020-06-01 00:00:00',
        ]);

        request()->request = $request;

        $educationService->create($request->all());

        $this->assertDatabaseCount('educations', 1);
    }

    /** @test */
    public function buat_data_duplikat_education_nama_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $educationService = app()->make(EducationService::class);

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
        $educationService->create($request->all());

        request()->request = $request2;
        $educationService->create($request2->all());
    }

    /** @test */
    public function buat_data_education_tanpa_nama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $educationService = app()->make(EducationService::class);

        $request = Request::create('/', 'POST', [
            'summary' => 'test2',
            'date' => '2020-06-01 00:00:02',
        ]);

        request()->request = $request;

        $data = $educationService->create($request->all());
    }

    /** @test */
    public function buat_data_education_tanpa_summary_akan_eror()
    {
        $this->expectException(QueryException::class);

        $educationService = app()->make(EducationService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'test',
            'date' => '2020-06-01 00:00:02',
        ]);

        request()->request = $request;

        $educationService->create($request->all());
    }

    /** @test */
    public function buat_data_education_tanpa_date_akan_eror()
    {
        $this->expectException(QueryException::class);

        $educationService = app()->make(EducationService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'test',
            'summary' => 'test2',
        ]);

        request()->request = $request;

        $educationService->create($request->all());
    }

    /** @test */
    public function update_data_education_dengan_id()
    {
        $education = Education::factory(5)->create()->first();

        $educationService = app()->make(EducationService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'test',
            'summary' => 'test2',
            'date' => '2020-06-01',
        ]);

        request()->request = $request;

        $educationService->update($education->id, $request->all());

        $this->assertDatabaseHas('educations', [
            'name' => 'test',
            'summary' => 'test2',
            'date' => '2020-06-01',
        ]);
    }

    /** @test */
    public function update_data_education_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        $educationRepository = app()->make(EducationRepository::class);

        $educationRepository->update(6, [
            'name' => 'test',
            'summary' => 'test2',
            'date' => '2020-06-01 00:00:02',
        ]);
    }

    /** @test */
    public function update_data_education_dengan_nama_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        Education::factory()->create([
            'name' => 'popo',
        ]);
        $education = Education::factory()->create();

        $educationService = app()->make(EducationService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'popo',
            'summary' => 'test2',
            'date' => '2020-06-01',
        ]);

        request()->request = $request;

        $educationService->update($education->id, $request->all());
    }

    /** @test */
    public function delete_data_education_dengan_id()
    {
        $sosialMedai = Education::factory()->create();

        $educationService = app()->make(EducationService::class);

        $educationService->delete($sosialMedai->id);

        $this->assertDatabaseCount('educations', 0);
    }

    /** @test */
    public function delete_data_education_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $educationService = app()->make(EducationService::class);

        $educationService->delete(3);
    }
}
