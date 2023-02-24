<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'summary' => fake()->text(),
            'awal' => Carbon::now(),
            'akhir' => Carbon::now(),
        ];
    }
}
