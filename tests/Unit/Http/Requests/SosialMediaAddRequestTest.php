<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\Skill\SkillAddRequest;
use App\Http\Requests\SosialMedia\SosialMediaAddRequest;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SosialMediaAddRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_validasi_berhasil()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaAddRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_kosong()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => '',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaAddRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_sudah_ada()
    {
        SocialMedia::factory()->create([
            'name' => 'php'
        ]);

        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaAddRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_url_kosong()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'url' => ''
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaAddRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_url_sudah_ada()
    {
        SocialMedia::factory()->create([
            'url' => 'http://google.com'
        ]);

        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaAddRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_url_salah()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'url' => 'sd'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaAddRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_file_kosong()
    {
        SocialMedia::factory()->create([
            'name' => 'php'
        ]);

        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'url' => 'http://google.com'
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaAddRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_file_bukan_image()
    {
        SocialMedia::factory()->create([
            'name' => 'php'
        ]);

        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->create('avatar.pdf', 1000, 'application/pdf');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaAddRequest();

        $validated = validator($request->all(), $skillRequest->rules())->validated();

        $this->assertTrue(true);
    }
}
