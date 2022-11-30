<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run()
    {
        Contact::factory()->create([
           "name" => "Akhmad Fahri Maulana",
           "email" => "akhmadfahri589@gmail.com",
        ]);
    }
}
