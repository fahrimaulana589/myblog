<?php

namespace Repositories;

use App\Models\Profile;
use App\Repositories\Profile\ProfileRepository;
use Tests\TestCase;

class ProfileRepositoryTest extends TestCase
{
    public $default_id = 1;

    /** @test */
    public function ambil_data_profile()
    {
        Profile::factory()->create(['id' => $this->default_id]);

        $profile_repository = app()->make(ProfileRepository::class);

        $profile = $profile_repository->view();

        $this->assertDatabaseHas('profiles', $profile->toArray());
    }

    /** @test */
    public function ubah_data_profile()
    {
        Profile::factory()->create(['id' => $this->default_id]);

        $profile_repository = app()->make(ProfileRepository::class);

        $profile_repository->change([
            'name' => 'fahri uk',
        ]);

        $this->assertDatabaseHas('profiles', [
            'name' => 'fahri uk',
        ]);
    }
}
