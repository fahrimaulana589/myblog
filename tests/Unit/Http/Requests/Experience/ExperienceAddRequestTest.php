<?php

namespace Http\Requests\Experience;

use App\Http\Requests\Experience\ExperienceAddRequest;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ExperienceAddRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_validasi_sukses()
    {
        $request = Request::create('/','POST',[
            'name' => 'SD',
            'summary' => 'Sdssssssssssss s gfg',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        request()->request = $request;

        $educationrequest = new ExperienceAddRequest();

        $request->validate($educationrequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_kosong()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/','POST',[
            'name' => '',
            'summary' => 'Sdssssssssssss s gfg',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        request()->request = $request;

        $educationrequest = new ExperienceAddRequest();

        $request->validate($educationrequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_nama_sudah_ada()
    {
        $this->expectException(ValidationException::class);

        Education::factory()->create([
            'name' => 'fahri'
        ]);

        $request = Request::create('/','POST',[
            'name' => 'fahri',
            'summary' => 'Sdssssssssssss s gfg',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        request()->request = $request;

        $educationrequest = new ExperienceAddRequest();

        $request->validate($educationrequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_summery_kosong()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/','POST',[
            'name' => '',
            'awal' => '2020-06-01 00:00:00',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        request()->request = $request;

        $educationrequest = new ExperienceAddRequest();

        $request->validate($educationrequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_awal_kosong()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/','POST',[
            'name' => 'fahri',
            'summary' => 'Sdssssssssssss s gfg',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        request()->request = $request;

        $educationrequest = new ExperienceAddRequest();

        $request->validate($educationrequest->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_gagal_akhir_kosong()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/','POST',[
            'name' => 'fahri',
            'summary' => 'Sdssssssssssss s gfg',
            'akhir' => '2020-06-01 00:00:00',
        ]);

        request()->request = $request;

        $educationrequest = new ExperienceAddRequest();

        $request->validate($educationrequest->rules());

        $this->assertTrue(true);
    }
}
