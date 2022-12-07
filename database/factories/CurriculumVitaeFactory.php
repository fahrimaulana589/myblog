<?php

namespace Database\Factories;

use App\Models\CurriculumVitae;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurriculumVitaeFactory extends Factory
{
    protected $model = CurriculumVitae::class;

    public function definition(): array
    {
        return [
            'photo' => fake()->unique()->imageUrl(),
            'name' => fake()->unique()->name(),
            'summary' => fake()->text(),
            'file' => fake()->unique()->imageUrl(),
        ];
    }
}
