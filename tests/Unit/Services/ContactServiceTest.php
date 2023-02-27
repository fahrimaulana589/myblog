<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\Profile;
use App\Services\Contact\ContactService;
use App\Services\Profile\ProfileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContactServiceTest extends TestCase
{
    public $default_id = 1;

    /** @test  */
    public function ambil_data_contact()
    {
        Contact::factory()->create();

        $contatc_service = app()->make(ContactService::class);

        $contatc = $contatc_service->view();

        Storage::disk()->assertExists($contatc->photo);

        $this->assertDatabaseHas('contacts', $contatc->toArray());
    }

    /** @test  */
    public function ambil_data_contact_kosong_maka_buat_contact_factory()
    {
        $contact_service = app()->make(ContactService::class);

        $contact = $contact_service->view();

        Storage::disk()->assertExists($contact->photo);

        $this->assertDatabaseHas('contacts', $contact->toArray());
    }
}
