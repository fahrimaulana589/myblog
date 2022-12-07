<?php

namespace Services;

use App\Models\Profile;
use App\Services\Profile\ProfileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        Storage::disk()->assertExists($profile->photo);

        $this->assertDatabaseHas('profiles', $profile->toArray());
    }

    /** @test  */
    public function ambil_data_profile_kosong_maka_buat_profile_factory()
    {
        $profile_service = app()->make(ProfileService::class);

        $profile = $profile_service->view();

        Storage::disk()->assertExists($profile->photo);

        $this->assertDatabaseHas('profiles', $profile->toArray());
    }

    /** @test  */
    public function update_data_profile_dengan_gambar()
    {
        Profile::factory()->create(['id' => $this->default_id]);

        $profile_service = app()->make(ProfileService::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = \Illuminate\Http\Request::create('/', 'POST', [
            'name' => 'fahri',
        ], files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $profile_service->change($request->all());

        $path = $profile_service->view()->photo;

        Storage::disk()->assertExists($path);

        $this->assertDatabaseHas('profiles', [
            'name' => 'fahri',
        ]);
    }

    /** @test  */
    public function update_data_profile_dengan_gambar_tidak_ada()
    {
        $profileOld = Profile::factory()->create(['id' => $this->default_id]);

        $profile_service = app()->make(ProfileService::class);

        $request = \Illuminate\Http\Request::create('/', 'POST', [
            'name' => 'fahri',
        ]);

        request()->request = $request;

        $profile_service->change($request->all());

        $path = $profileOld->photo;

        Storage::disk()->assertExists($path);

        $this->assertDatabaseHas('profiles', [
            'name' => 'fahri',
        ]);
    }
}
