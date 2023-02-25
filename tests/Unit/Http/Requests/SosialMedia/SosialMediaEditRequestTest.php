<?php

namespace Http\Requests\SosialMedia;

use App\Http\Requests\SosialMedia\SosialMediaEditRequest;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SosialMediaEditRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_validasi_sukses()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $sisialmedia = SocialMedia::factory()->create();

        $request = Request::create('/1', 'POST', [
            'id' => $sisialmedia->id,
            'name' => 'php',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_sukses_gambar_tidak_ada()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $sisialmedia = SocialMedia::factory()->create();

        $request = Request::create('/1', 'POST', [
            'id' => $sisialmedia->id,
            'name' => 'php',
            'url' => 'http://google.com'
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_sukses_update_nama_sama()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $sisialmedia = SocialMedia::factory()->create([
            'name' => 'php'
        ]);

        $request = Request::create('/1', 'POST', [
            'id' => $sisialmedia->id,
            'name' => 'php',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_sukses_update_url_sama()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $sisialmedia = SocialMedia::factory()->create([
            'url' => 'http://google.com'
        ]);

        $request = Request::create('/1', 'POST', [
            'id' => $sisialmedia->id,
            'name' => 'php',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_kosong()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $sisialmedia = SocialMedia::factory()->create();

        $request = Request::create('/1', 'POST', [
            'id' => $sisialmedia->id,
            'name' => '',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_sudah_ada()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $sisialmedia = SocialMedia::factory()->create();

        SocialMedia::factory()->create([
            'name' => 'php'
        ]);

        $request = Request::create('/1', 'POST', [
            'id' => $sisialmedia->id,
            'name' => 'php',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_url_kosong()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $sisialmedia = SocialMedia::factory()->create();

        $request = Request::create('/1', 'POST', [
            'id' => $sisialmedia->id,
            'name' => 'php',
            'url' => ''
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_url_sudah_ada()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $sisialmedia = SocialMedia::factory()->create();

        SocialMedia::factory()->create([
            'url' => 'http://google.com'
        ]);

        $request = Request::create('/1', 'POST', [
            'id' => $sisialmedia->id,
            'name' => 'php',
            'url' => 'http://google.com'
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new SosialMediaEditRequest();

        $request->validate( $skillRequest->rules());

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

        $skillRequest = new SosialMediaEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }
}
