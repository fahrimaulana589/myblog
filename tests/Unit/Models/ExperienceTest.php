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
        $result = Schema::hasColumns("experiences", [
            "name", "summary", "date"
        ]);

        $this->assertTrue($result);
    }

    /** @test  */
    public function experience_database_name_collumn_is_unique()
    {
        $this->expectException(QueryException::class);

        Experience::factory()->create([
            "name" => "freelance"
        ]);

        Experience::factory()->create([
            "name" => "freelance"
        ]);
    }

    /** @test */
    public function experience_database_date_collumn_is_date()
    {
        $this->expectException(QueryException::class);

        Experience::factory()->create([
            "date" => "freelance s"
        ]);

    }
}
