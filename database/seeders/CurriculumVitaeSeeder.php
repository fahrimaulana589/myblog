<?php

namespace Database\Seeders;

use App\Models\CurriculumVitae;
use Illuminate\Database\Seeder;
use Storage;

class CurriculumVitaeSeeder extends Seeder
{
    public function run()
    {
        CurriculumVitae::factory()->create([
            "name" => "Akhmad Fahri Maulan",
            "summary" => "Perkenalkan nama saya akhmad fahri maulana kalian dapat memanggil saya fahri,
                        saya bertempat tinggal di tegal, jawa tengah, berpengalaman dalam membuat web dengan framework laravel"
        ]);
    }
}
