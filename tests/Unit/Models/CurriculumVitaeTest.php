<?php

namespace Tests\Unit\Models;

use App\Models\CurriculumVitae;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CurriculumVitaeTest extends TestCase
{
    /** @test  */
    public function curriculum_vitaes_table_has_expected_column()
    {
        $result = Schema::hasColumns('curriculum_vitaes', [
            'name', 'photo', 'summary', 'file',
        ]);

        $this->assertTrue($result);
    }

    /** @test  */
    public function curriculum_vitaes_table_name_column_is_unique()
    {
        $this->expectException(QueryException::class);

        CurriculumVitae::factory()->create([
            'name' => 'fahri',
        ]);

        CurriculumVitae::factory()->create([
            'name' => 'fahri',
        ]);
    }

    /** @test  */
    public function curriculum_vitaes_table_photo_column_is_unique()
    {
        $this->expectException(QueryException::class);

        CurriculumVitae::factory()->create([
            'photo' => 'default.png',
        ]);

        CurriculumVitae::factory()->create([
            'photo' => 'default.png',
        ]);
    }

    /** @test  */
    public function curriculum_vitaes_table_file_column_is_unique()
    {
        $this->expectException(QueryException::class);

        CurriculumVitae::factory()->create([
            'file' => 'default.png',
        ]);

        CurriculumVitae::factory()->create([
            'file' => 'default.png',
        ]);
    }
}
