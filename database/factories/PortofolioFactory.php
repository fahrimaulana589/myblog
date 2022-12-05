<?php

namespace Database\Factories;

use App\Models\Portofolio;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortofolioFactory extends Factory
{
    protected $model = Portofolio::class;

    public function definition(): array
    {
        return [
            "name" => fake()->unique()->name,
            "image" => fake()->unique()->imageUrl(),
            "content" => fake()->text(),
            "comment" => fake()->uuid(),
        ];
    }
}
