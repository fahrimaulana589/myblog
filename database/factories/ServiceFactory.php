<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'icon' => UploadedFile::fake()->image('avatar.jpg')->store('files'),
            'summary' => fake()->text(200),
        ];
    }
}
