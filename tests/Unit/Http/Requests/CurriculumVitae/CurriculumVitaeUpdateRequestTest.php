<?php

namespace Http\Requests\CurriculumVitae;

use App\Http\Requests\CurriculumVitae\CurriculumVitaeUpdateRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CurriculumVitaeUpdateRequestTest extends TestCase
{
    public function test_validasi_berhasil()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $file2 = UploadedFile::fake()->create('avatar.pdf',1000,'application/pdf');

        $request = Request::create('/1', 'POST', [
            'summary' => 'test',
            'name' => 'php',
        ], files: [
            'file_1' => $file,
            'file_2' => $file2,
        ]);

        request()->request = $request;

        $skillRequest = new CurriculumVitaeUpdateRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_file_bukan_gambar()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->create('gambar.pdf',1000,'application/pdf');

        $request = Request::create('/1', 'POST', [
            'summary' => 'test',
            'name' => 'php',
        ], files: [
            'file_1' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new CurriculumVitaeUpdateRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_file_bukan_pdf()
    {
        $this->expectException(ValidationException::class);

        $file = UploadedFile::fake()->image('image.jpg');

        $request = Request::create('/1', 'POST', [
            'summary' => 'test',
            'name' => 'php',
        ], files: [
            'file_2' => $file,
        ]);

        request()->request = $request;

        $skillRequest = new CurriculumVitaeUpdateRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);
    }
}
