<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\SkillAddRequest;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Tests\TestCase;

class SkillAddRequestTest extends TestCase
{
    public function test_validasi_berhasil()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SkillAddRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_kosong()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => '',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SkillAddRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_sudah_ada()
    {
        Skill::factory()->create([
            'name' => 'tets',
        ]);

        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'tets',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SkillAddRequest();

        validator($request->all(), $skillRequest->rules())->validated();
    }

    public function test_validasi_gagal_nama_tidak_ada()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', [
            'name' => '',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SkillAddRequest();

        validator($request->all(), $skillRequest->rules())->validated();
    }

    public function test_validasi_gagal_icon_tidak_ada()
    {
        $this->expectException(InvalidArgumentException::class);

        $request = Request::create('/', 'POST', [
            'name' => 's',
        ], files: [
            'file' => '',
        ]);

        request()->request = $request;

        $skillRequest = new SkillAddRequest();

        validator($request->all(), $skillRequest->rules())->validated();
    }

    public function test_validasi_gagal_icon_bukan_image()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->create('avatar.pdf', 1000, 'application/pdf');

        $request = Request::create('/', 'POST', [
            'name' => '',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SkillAddRequest();

        validator($request->all(), $skillRequest->rules())->validated();
    }
}
