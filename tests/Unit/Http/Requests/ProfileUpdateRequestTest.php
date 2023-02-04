<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Http\Requests\Skill\SkillAddRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ProfileUpdateRequestTest extends TestCase
{
    public function test_validasi_berhasil()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'summary' => 'test',
            'slogan' => 'test',
            'name' => 'php',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new ProfileUpdateRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_file_bukan_image()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->create('avatar.pdf', 1000, 'application/pdf');

        $request = Request::create('/1', 'POST', [
            'summary' => 'test',
            'slogan' => 'test',
            'name' => 'php',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new ProfileUpdateRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }
}
