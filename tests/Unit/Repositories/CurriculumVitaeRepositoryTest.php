<?php

namespace Repositories;

use App\Models\CurriculumVitae;
use App\Models\Profile;
use App\Repositories\CurriculumVitae\CurriculumVitaeRepository;
use App\Repositories\Profile\ProfileRepository;
use Tests\TestCase;

class CurriculumVitaeRepositoryTest extends TestCase
{

    public $default_id = 1;

    /** @test */
    public function ambil_data_curriculumvitae()
    {
        CurriculumVitae::factory()->create(['id' => $this->default_id]);

        $curriculumvitae_repository = app()->make(CurriculumVitaeRepository::class);

        $profile = $curriculumvitae_repository->view();

        $this->assertDatabaseHas('curriculum_vitaes', $profile->toArray());
    }

    /** @test */
    public function ubah_data_curriculumvitae()
    {
        CurriculumVitae::factory()->create(['id' => $this->default_id]);

        $curriculumvitae_repository = app()->make(CurriculumVitaeRepository::class);

        $curriculumvitae_repository->change([
            'name' => 'fahri uk',
        ]);

        $this->assertDatabaseHas('curriculum_vitaes', [
            'name' => 'fahri uk',
        ]);
    }
}
