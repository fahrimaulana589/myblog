<?php

namespace Http\Requests\Service;

use App\Http\Requests\Service\ServiceAddRequest;
use App\Http\Requests\SosialMedia\SosialMediaAddRequest;
use App\Models\Service;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ServiceAddRequestTest extends TestCase
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
            'summary' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new ServiceAddRequest();

        $request->validate($skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_kosong()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => '',
            'summary' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new ServiceAddRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_sudah_ada()
    {
        Service::factory()->create([
            'name' => 'php'
        ]);

        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'summary' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new ServiceAddRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_summary_kosong()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'summary' => ''
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new ServiceAddRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_file_kosong()
    {
        Service::factory()->create([
            'name' => 'php'
        ]);

        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'summary' => 'http://google.com'
        ]);

        request()->request = $request;

        $skillRequest = new ServiceAddRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_file_bukan_image()
    {
        Service::factory()->create([
            'name' => 'php'
        ]);

        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->create('avatar.pdf', 1000, 'application/pdf');

        $request = Request::create('/1', 'POST', [
            'name' => 'php',
            'summary' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new ServiceAddRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }
}
