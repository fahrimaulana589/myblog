<?php

namespace Database\Factories;

use App\Models\Education;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    protected $model = Education::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'summary' => fake()->text(200),
            'date' => fake()->date(),
        ];
    }
}
