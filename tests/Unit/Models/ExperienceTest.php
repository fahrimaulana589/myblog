<?php

namespace Tests\Unit\Models;

use App\Models\Experience;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ExperienceTest extends TestCase
{
    /** @test */
    public function experience_database_has_expected_collumn()
    {
        $result = Schema::hasColumns('experiences', [
            'name', 'summary', 'awal','akhir',
        ]);

        $this->assertTrue($result);
    }

    /** @test  */
    public function experience_database_name_collumn_is_unique()
    {
        $this->expectException(QueryException::class);

        Experience::factory()->create([
            'name' => 'freelance',
        ]);

        Experience::factory()->create([
            'name' => 'freelance',
        ]);
    }

    /** @test */
    public function experience_database_awal_collumn_is_date()
    {
        $this->expectException(QueryException::class);

        Experience::factory()->create([
            'awal' => 'freelance s',
        ]);
    }
    /** @test */
    public function experience_database_akhir_collumn_is_date()
    {
        $this->expectException(QueryException::class);

        Experience::factory()->create([
            'akhir' => 'freelance s',
        ]);
    }
}
