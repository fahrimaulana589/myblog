<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {
        return [
            'icon' => UploadedFile::fake()->image('avatar.jpg')->store('files'),
            'name' => fake()->unique()->name,
        ];
    }
}
