<?php

namespace Tests\Unit\Repositories;

use App\Models\Contact;
use App\Models\CurriculumVitae;
use App\Repositories\Contact\ContactRepository;
use App\Repositories\CurriculumVitae\CurriculumVitaeRepository;
use Tests\TestCase;

class ContactRepositoryTest extends TestCase
{
    public $default_id = 1;

    /** @test */
    public function ambil_data_contact()
    {
        Contact::factory()->create(['id' => $this->default_id]);

        $contact_repository = app()->make(ContactRepository::class);

        $contact = $contact_repository->view();

        $this->assertDatabaseHas('contacts', $contact->toArray());
    }

    /** @test */
    public function ubah_data_contact()
    {
        Contact::factory()->create(['id' => $this->default_id]);

        $contact_repository = app()->make(ContactRepository::class);

        $contact_repository->change([
            'name' => 'fahri uk',
        ]);

        $this->assertDatabaseHas('contacts', [
            'name' => 'fahri uk',
        ]);
    }
}
