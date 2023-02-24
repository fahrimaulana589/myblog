<?php

namespace Tests\Unit\Repositories;

use App\Models\Education;
use App\Repositories\Education\EducationRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class EducationRepositoryTest extends TestCase
{
    public function test_ambil_semua_education()
    {
        Education::factory(5)->create();

        $educationRepository = app()->make(EducationRepository::class);

        $educations = $educationRepository->all();

        $this->assertTrue($educations->count() == 5);
    }

    public function test_ambil_detail_education_dengan_id()
    {
        $educations = Education::factory(5)->create();

        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->find($educations->first()->id);

        $this->assertTrue($education->id == $educations->first()->id);
    }

    public function test_ambil_detail_education_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        Education::factory(5)->create();

        $educationRepository = app()->make(EducationRepository::class);

        $educationRepository->findOrFail(121);
    }

    public function test_buat_data_education()
    {
        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->create([
            'name' => 'test',
            'summary' => 'test',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        $this->assertDatabaseCount('educations', 1);
    }

    public function test_buat_data_education_dengan_nama_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->create([
            'name' => 'test',
            'summary' => 'test',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        $education = $educationRepository->create([
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_buat_data_education_dengan_nama_tidak_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->create([
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_buat_data_education_dengan_summary_tidak_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->create([
            'name' => 'test',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_buat_data_education_dengan_awal_tidak_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->create([
            'name' => 'test',
            'summary' => 'test2',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_buat_data_education_dengan_akhir_tidak_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->create([
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_update_data_education_dengan_id()
    {
        $idEducation = Education::factory(5)->create()->first()->id;

        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->update($idEducation, [
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        $this->assertDatabaseHas('educations', [
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_update_data_education_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $idEducation = Education::factory(5)->create()->first()->id;

        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->update(121, [
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_update_data_education_dengan_nama_sudah_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $data1 = Education::factory()->create([
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
        $data2 = Education::factory()->create();

        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->update($data2->id, [
            'name' => 'test',
            'summary' => 'test2',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);
    }

    public function test_update_data_education_dengan_icon_sudah_ada_akan_eror()
    {
        $this->expectException(QueryException::class);

        $data1 = Education::factory()->create([
            'icon' => 'teasst.jpg',
        ]);
        $data2 = Education::factory()->create();

        $educationRepository = app()->make(EducationRepository::class);

        $education = $educationRepository->update($data2->id, [
            'icon' => 'teasst.jpg',
        ]);
    }

    public function test_delete_education_dari_id()
    {
        $education = Education::factory()->create();

        $educationRepository = app()->make(EducationRepository::class);

        $educationRepository->delete($education->id);

        $this->assertDatabaseCount('educations', 0);
    }

    public function test_delete_education_dari_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $educationRepository = app()->make(EducationRepository::class);

        $educationRepository->delete(121212);

        $this->assertDatabaseCount('educations', 0);
    }
}
