<?php

namespace Tests\Unit\Models;

use App\Models\Profile;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /** @test  */
    public function profiles_database_has_expected_column()
    {
        $result = Schema::hasColumns('profiles', [
            'name', 'summary', 'photo', 'slogan',
        ]);

        $this->assertTrue($result);
    }

    /** @test  */
    public function profiles_hanya_dapat_diisi_satu_row_dengan_id_1()
    {
        $this->expectException(QueryException::class);

        Profile::factory()->create([
            'id' => 1,
            'photo' => 'default',
        ]);

        Profile::factory()->create([
            'id' => 2,
            'photo' => 's',
        ]);
    }

    /** @test  */
    public function profiles_database_photo_column_is_unique()
    {
        $this->expectException(QueryException::class);

        Profile::factory()->create([
            'photo' => 'default',
        ]);

        Profile::factory()->create([
            'photo' => 'default',
        ]);
    }
}
