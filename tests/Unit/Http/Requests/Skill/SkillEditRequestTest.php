<?php

namespace Http\Requests\Skill;

use App\Http\Requests\Skill\SkillEditRequest;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SkillEditRequestTest extends TestCase
{
    public function test_validasi_sukses()
    {
        $skill = Skill::factory()->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'id' => $skill->id,
            'name' => 'php',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SkillEditRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_sukses_update_nama_sama()
    {
        $skill = Skill::factory()->create([
            'name' => 'php'
        ]);
        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'id' => $skill->id,
            'name' => 'php',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SkillEditRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_sukses_icon_kosong()
    {
        $skill = Skill::factory()->create();

        $request = Request::create('/1', 'POST', [
            'id' => $skill->id,
            'name' => 'php',
        ]);

        request()->request = $request;

        $skillRequest = new SkillEditRequest();

        $request->validate($skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_kosong()
    {
        $this->expectException(ValidationException::class);

        $skill = Skill::factory()->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'id' => $skill->id,
            'name' => '',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SkillEditRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_sudah_ada()
    {
        $this->expectException(ValidationException::class);

        $skill = Skill::factory()->create();

        Skill::factory()->create([
            'name' => 'php'
        ]);

        $request = Request::create('/1', 'POST', [
            'id' => $skill->id,
            'name' => 'php',
        ]);

        request()->request = $request;

        $skillRequest = new SkillEditRequest();

        $request->validate($skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_icon_bukan_image()
    {
        $this->expectException(ValidationException::class);

        $skill = Skill::factory()->create();

        $file = UploadedFile::fake()->create('avatar.pdf', 1000, 'application/pdf');

        $request = Request::create('/', 'POST', [
            'id' => $skill->id,
            'name' => 'php',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SkillEditRequest();

        $request->validate( $skillRequest->rules());
    }
}
