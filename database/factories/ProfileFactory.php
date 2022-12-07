<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'photo' => UploadedFile::fake()->image('avatar.jpg')->store('files'),
            'name' => fake()->name(),
            'summary' => fake()->text(),
            'slogan' => fake()->word(),
        ];
    }
}
