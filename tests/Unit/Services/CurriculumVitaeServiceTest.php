<?php

namespace Tests\Unit\Services;

use App\Models\CurriculumVitae;
use App\Models\Profile;
use App\Services\CurriculumVitae\CurriculumVitaeService;
use App\Services\Profile\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CurriculumVitaeServiceTest extends TestCase
{
    public $default_id = 1;

    /** @test  */
    public function ambil_data_curriculumvitae()
    {
        CurriculumVitae::factory()->create();

        $curriculumvitae_service = app()->make(CurriculumVitaeService::class);

        $curriculumvitae = $curriculumvitae_service->view();

        Storage::disk()->assertExists($curriculumvitae->photo);

        $this->assertDatabaseHas('curriculum_vitaes', $curriculumvitae->toArray());
    }

    /** @test  */
    public function ambil_data_curriculumvitae_kosong_maka_buat_curriculumvitae_factory()
    {
        $curriculumvitae_service = app()->make(CurriculumVitaeService::class);

        $curriculumvitae = $curriculumvitae_service->view();

        Storage::disk()->assertExists($curriculumvitae->photo);

        $this->assertDatabaseHas('curriculum_vitaes', $curriculumvitae->toArray());
    }

    /** @test  */
    public function update_data_curriculumvitae_dengan_file()
    {
        CurriculumVitae::factory()->create(['id' => $this->default_id]);

        $curriculumvitae_service = app()->make(CurriculumVitaeService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');
        $file2 = UploadedFile::fake()->create('file.pdf',1000,'pdf');

        $request = Request::create('/', 'POST', [
            'name' => 'fahri',
        ], files: [
            'file_1' => $file,
            'file_2' => $file2,
        ]);

        request()->request = $request;

        $curriculumvitae_service->change($request->all());

        $path = $curriculumvitae_service->view()->photo;
        $path2 = $curriculumvitae_service->view()->file;

        Storage::disk()->assertExists($path);
        Storage::disk()->assertExists($path2);

        $this->assertDatabaseHas('curriculum_vitaes', [
            'name' => 'fahri',
        ]);
    }

    /** @test  */
    public function update_data_curriculumvitae_dengan_file_tidak_ada()
    {
        $curriculumvitaeOld = CurriculumVitae::factory()->create(['id' => $this->default_id]);

        $curriculumvitae_service = app()->make(CurriculumVitaeService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'fahri',
        ]);

        request()->request = $request;

        $curriculumvitae_service->change($request->all());

        $path = $curriculumvitaeOld->photo;

        Storage::disk()->assertExists($path);

        $this->assertDatabaseHas('curriculum_vitaes', [
            'name' => 'fahri',
        ]);
    }

    /** @test  */
    public function update_data_curriculumvitae_dengan_gambar_yang_bernilai_bukan_file()
    {
        $curriculumvitaeOld = CurriculumVitae::factory()->create(['id' => $this->default_id]);

        $curriculumvitae_service = app()->make(CurriculumVitaeService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'fahri',
            'file' => 'as',
        ]);

        request()->request = $request;

        $curriculumvitae_service->change($request->all());

        $path = $curriculumvitaeOld->photo;

        Storage::disk()->assertExists($path);

        $this->assertDatabaseHas('curriculum_vitaes', [
            'name' => 'fahri',
        ]);
    }
}
