<?php

namespace Tests\Unit\Models;

use App\Models\Contact;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ContactTest extends TestCase
{
    /** @test */
    public function contacts_table_has_expected_column()
    {
        $result = Schema::hasColumns("contacts", [
            "name", "summary", "email", "whatsapp"
        ]);

        $this->assertTrue($result);
    }

    /** @test */
    public function contacts_table_name_is_unique()
    {
        $this->expectException(QueryException::class);

        Contact::factory()->create([
            "name" => "akhmad fahri maulana"
        ]);

        Contact::factory()->create([
            "name" => "akhmad fahri maulana"
        ]);
    }
    /** @test */
    public function contacts_table_email_is_unique()
    {
        $this->expectException(QueryException::class);

        Contact::factory()->create([
            "email" => "akhmadfahri589@gmail.com"
        ]);

        Contact::factory()->create([
            "email" => "akhmadfahri589@gmail.com"
        ]);
    }
    /** @test */
    public function contacts_table_whatsapp_is_unique()
    {
        $this->expectException(QueryException::class);

        Contact::factory()->create([
            "whatsapp" => "08888888888"
        ]);

        Contact::factory()->create([
            "whatsapp" => "08888888888"
        ]);
    }

}
