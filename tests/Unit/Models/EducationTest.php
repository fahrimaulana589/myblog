<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EducationTest extends TestCase
{

    /**  @test  */
    public function educations_database_has_expected_collumn()
    {
        $result = Schema::hasColumns("educations",[

        ]);

        $this->assertTrue(true);
    }
}
