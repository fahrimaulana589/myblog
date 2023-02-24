<?php

namespace Tests\Unit\Models;

use App\Models\Education;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EducationTest extends TestCase
{
    /**  @test  */
    public function educations_database_has_expected_collumn()
    {
        $result = Schema::hasColumns('educations', [
            'name', 'summary', 'awal','akhir',
        ]);

        $this->assertTrue($result);
    }

    /** @test  */
    public function education_database_name_is_unique()
    {
        $this->expectException(QueryException::class);

        Education::factory()->create([
            'name' => 'smk hasry',
        ]);

        Education::factory()->create([
            'name' => 'smk hasry',
        ]);
    }

    /** @test  */
    public function education_database_awal_is_date()
    {
        $this->expectException(QueryException::class);

        Education::factory(1)->create([
            'awal' => '1-2-2000',
        ]);
    }

    /** @test  */
    public function education_database_akhir_is_date()
    {
        $this->expectException(QueryException::class);

        Education::factory(1)->create([
            'akhir' => '1-2-2000',
        ]);
    }
}
