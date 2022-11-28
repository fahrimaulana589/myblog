<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CurriculumVitaeSeeder::class,
            EducationSeeder::class,
            ExperienceSeeder::class,
            ProfileSeeder::class,
            ServiceSeeder::class,
            SkillSeeder::class,
            SocialMediaSeeder::class
        ]);
    }
}
