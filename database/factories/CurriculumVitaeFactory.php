<?php

namespace Database\Factories;

use App\Models\CurriculumVitae;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class CurriculumVitaeFactory extends Factory
{
    protected $model = CurriculumVitae::class;

    public function definition(): array
    {
        return [
            'photo' => UploadedFile::fake()->image('avatar.jpg')->store('files'),
            'name' => fake()->unique()->name(),
            'summary' => fake()->text(),
            'file' => UploadedFile::fake()->image('avatar.jpg')->store('files'),
        ];
    }
}
