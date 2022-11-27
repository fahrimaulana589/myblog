<?php

namespace Tests\Unit\Models;

use App\Models\Skill;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SkillTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function skills_database_has_expected_column()
    {
        $result = Schema::hasColumns("skills",[
            "icon","name"
        ]);

        $this->assertTrue($result);

    }

    /** @test  */
    public function skills_database_icon_column_is_unique()
    {
        $this->expectException(QueryException::class);

        Skill::factory()->create([
            "icon" => "default.png"
        ]);

        Skill::factory()->create([
            "icon" => "default.png"
        ]);
    }

    /** @test  */
    public function skills_database_name_column_is_unique()
    {
        $this->expectException(QueryException::class);

        Skill::factory()->create([
            "name" => "javascript"
        ]);

        Skill::factory()->create([
            "name" => "javascript"
        ]);
    }
}
