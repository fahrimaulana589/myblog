<?php

namespace Services;

use App\Models\Profile;
use App\Services\Profile\ProfileService;
use Tests\TestCase;

class ProfileServiceTest extends TestCase
{
    public $default_id = 1;

    /** @test  */
    public function ambil_data_profile()
    {
        Profile::factory()->create();

        $profile_service = app()->make(ProfileService::class);

        $profile = $profile_service->view();

        $this->assertDatabaseHas("profiles", $profile->toArray());
    }

    /** @test  */
    public function ambil_data_profile_kosong_maka_buat_profile_factory()
    {
        $profile_service = app()->make(ProfileService::class);

        $profile = $profile_service->view();

        $this->assertDatabaseHas("profiles", $profile->toArray());
    }

    /** @test  */
    public function update_data_profile()
    {
        Profile::factory()->create(["id" => $this->default_id]);

        $profile_service = app()->make(ProfileService::class);

        $profile_service->change([
            'name' => "fahri"
        ]);

        $this->assertDatabaseHas("profiles", [
            "name" => "fahri"
        ]);
    }

    /** @test  */
    public function update_data_profile_kosong_maka_buat_profile_factory()
    {
        $profile_service = app()->make(ProfileService::class);

        $profile_service->change([
            'name' => "fahri"
        ]);

        $profile = $profile_service->view();

        $this->assertDatabaseHas("profiles", $profile->toArray());
    }

}
