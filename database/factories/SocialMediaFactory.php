<?php

namespace Database\Factories;

use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialMediaFactory extends Factory
{
    protected $model = SocialMedia::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'icon' => fake()->unique()->imageUrl(),
            'url' => fake()->unique()->name(),
        ];
    }
}
