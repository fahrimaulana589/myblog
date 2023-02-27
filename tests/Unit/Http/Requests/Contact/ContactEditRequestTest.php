<?php

namespace Http\Requests\Contact;

use App\Http\Requests\Contact\ContactEditRequest;
use App\Http\Requests\CurriculumVitae\CurriculumVitaeUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ContactEditRequestTest extends TestCase
{

    public function test_validasi_berkasil(){

        $request = Request::create('/1', 'POST', [
            'summary' => 'test',
            'name' => 'php',
            'email' => 'php@ph.id',
            'whatsapp' => '088806026374',
        ]);

        request()->request = $request;

        $skillRequest = new ContactEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);

    }

    public function test_validasi_gagal_format_email_salah(){

        $this->expectException(ValidationException::class);

        $request = Request::create('/1', 'POST', [
            'summary' => 'test',
            'name' => 'php',
            'email' => 'php',
            'whatsapp' => '088806026374',
        ]);

        request()->request = $request;

        $skillRequest = new ContactEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);

    }

    public function test_validasi_gagal_format_whatsaap_salah(){

        $this->expectException(ValidationException::class);

        $request = Request::create('/1', 'POST', [
            'summary' => 'test',
            'name' => 'php',
            'email' => 'php@pj.id',
            'whatsapp' => 'ss',
        ]);

        request()->request = $request;

        $skillRequest = new ContactEditRequest();

        $request->validate( $skillRequest->rules());

        $this->assertTrue(true);

    }
}
