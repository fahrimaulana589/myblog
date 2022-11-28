<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Akhmad Fahri Maulana',
            'username' => 'Fanri589',
            'email' => 'akhmadfahri859@gmail.com',
        ]);
    }
}
