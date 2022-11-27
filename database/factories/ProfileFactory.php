<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'photo' => fake()->unique()->imageUrl(),
            'name' => fake()->name(),
            'summary' => fake()->text(),
            'slogan' => fake()->word(),
        ];
    }
}
