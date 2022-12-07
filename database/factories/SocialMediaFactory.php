<?php

namespace Database\Factories;

use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class SocialMediaFactory extends Factory
{
    protected $model = SocialMedia::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'icon' => UploadedFile::fake()->image('avatar.jpg')->store('files'),
            'url' => fake()->unique()->name(),
        ];
    }
}
