<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_database_has_expected_columns()
    {
        $result = Schema::hasColumns('users', [
            'id', 'name', 'username', 'photo', 'email', 'email_verified_at', 'password'
        ]);
        $this->assertTrue($result);
    }

    /** @test */
    public function users_database_email_column_is_unique()
    {
        $this->expectException(QueryException::class);

        User::factory()->create([
            "email" => "akhmadfahri589@gmail.com",
        ]);

        User::factory()->create([
            "email" => "akhmadfahri589@gmail.com",
        ]);

        $this->assertTrue(true);
    }

    /** @test */
    public function users_database_username_column_is_unique()
    {
        $this->expectException(QueryException::class);

        User::factory()->create([
            "username" => "akhmad589"
        ]);

        User::factory()->create([
            "username" => "akhmad589"
        ]);
    }

    /** @test */
    public function users_database_email_column_is_photo()
    {
        $this->expectException(QueryException::class);

        User::factory()->create([
            "photo" => "default.png"
        ]);

        User::factory()->create([
            "photo" => "default.png"
        ]);
    }
}
