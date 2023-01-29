<?php

namespace Tests\Unit\Services;

use App\Models\Skill;
use App\Models\SocialMedia;
use App\Repositories\SosialMedia\SosialMediaRepository;
use App\Services\Skill\SkillService;
use App\Services\SosialMedia\SosialMediaService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SkillServiceTest extends TestCase
{
    /** @test  */
    public function ambil_semua_data_skill()
    {
        $skillService = app()->make(SkillService::class);

        Skill::factory(5)->create();

        $skills = $skillService->all();

        $this->assertTrue($skills->count() == 5);
    }

    public function test_ambil_data_skill_dengan_id()
    {
        $skillService = app()->make(SkillService::class);

        $skills = Skill::factory(5)->create();

        $idSkill = $skills->first()->id;

        $skill = $skillService->findOrFail($idSkill);

        $this->assertTrue($skill->id == $idSkill);
    }

    public function test_buat_data_skill()
    {
        $skillService = app()->make(SkillService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
        ],files: [
            'file' => $file
        ]);

        request()->request = $request;


        $data = $skillService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 1);

        $this->assertDatabaseCount('skills', 1);
    }

    public function test_buat_skill_media_tanpa_gambar()
    {
        $skillService = app()->make(SkillService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
        ]);

        request()->request = $request;

        $data = $skillService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);

        $this->assertDatabaseCount('skills', 1);
    }

    public function test_buat_data_skill_gambar_bernilai_bukan_file()
    {
        $skillService = app()->make(SkillService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
            'file' => 'tset',
        ]);

        request()->request = $request;

        $data = $skillService->create($request->all());

        Storage::disk()->assertExists($data->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);

        $this->assertDatabaseCount('skills', 1);
    }

    public function test_buat_data_duplikat_skill_nama_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $skillService = app()->make(SkillService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');
        $file2 = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
         ], files: [
            'file' => $file,
        ]);

        $request2 = Request::create('/', 'POST', [
            'name' => 'halo',
        ], files: [
            'file' => $file2,
        ]);

        request()->request = $request;
        $skillService->create($request->all());

        request()->request = $request2;
        $skillService->create($request2->all());
    }

    public function test_buat_data_duplikat_skill_icon_sama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $skillService = app()->make(SkillService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
        ], files: [
            'file' => $file,
        ]);

        $request2 = Request::create('/', 'POST', [
            'name' => 'halo2',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillService->create($request->all());
        $skillService->create($request2->all());
    }

    public function test_buat_data_skill_tanpa_nama_akan_eror()
    {
        $this->expectException(QueryException::class);

        $skillService = app()->make(SkillService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $data = $skillService->create($request->all());
    }

    public function test_update_data_skill_dengan_id()
    {
        $skill = Skill::factory(5)->create()->first();

        $skillService = app()->make(SkillService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillService->update($skill->id, $request->all());

        $newSkill = $skillService->findOrFail($skill->id);

        Storage::assertMissing($skill->icon);
        Storage::assertExists($newSkill->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 5);

        $this->assertDatabaseHas('skills', [
            'name' => 'halo',
            'icon' => $newSkill->icon,
        ]);
    }

    public function test_update_data_skill_dengan_id_tidak_ada()
    {
        $this->expectException(ModelNotFoundException::class);

        $skillService = app()->make(SkillService::class);

        $skillService->update(6, [
            'name' => 'test',
            'icon' => 'image.png',
        ]);
    }

    public function test_update_data_skill_dengan_gambar()
    {
        $skill = Skill::factory(5)->create()->first();

        $skillService = app()->make(SkillService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
            'url' => 'test.com',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillService->update($skill->id, $request->all());

        $newSkill = $skillService->findOrFail($skill->id);

        Storage::assertMissing($skill->icon);
        Storage::assertExists($newSkill->icon);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 5);

        $this->assertDatabaseHas('skills', [
            'name' => 'halo',
            'icon' => $newSkill->icon,
        ]);
    }

    public function test_update_data_skill_dengan_gambar_tidak_ada()
    {
        $skill = Skill::factory(5)->create()->first();

        $skillService = app()->make(SkillService::class);

        $request = Request::create('/', 'POST', [
            'name' => 'halo',
        ]);

        request()->request = $request;

        $skillService->update($skill->id, $request->all());

        $newSkill = $skillService->findOrFail($skill->id);

        Storage::assertExists($newSkill->icon);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 5);

        $this->assertDatabaseHas('skills', [
            'name' => 'halo',
            'icon' => $newSkill->icon,
        ]);
    }

    public function test_delete_data_skill_dengan_id()
    {
        $skill = Skill::factory()->create();

        $skillService = app()->make(SkillService::class);

        $skillService->delete($skill->id);

        Storage::assertMissing($skill->icon);

        $this->assertDatabaseCount('skills', 0);
    }

    public function test_delete_data_skill_dengan_id_tidak_ada_akan_eror()
    {
        $this->expectException(ModelNotFoundException::class);

        $skillService = app()->make(SkillService::class);

        $skillService->delete(3);
    }
}
