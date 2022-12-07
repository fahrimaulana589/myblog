<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run()
    {
        Profile::factory()->create([
            'name' => 'Akhmad Fahri Maulana',
            'summary' => 'Hai Selamat Datang Di Blog saya',
            'slogan' => 'Tak kenal maka tak sayang',
        ]);
    }
}
