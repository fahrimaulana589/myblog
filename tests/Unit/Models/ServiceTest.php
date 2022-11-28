<?php

namespace Tests\Unit\Models;

use App\Models\Service;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    /** @test  */
    public function services_table_has_expected_column()
    {
        $result = Schema::hasColumns("services",[
           "name","icon","summary"
        ]);

        $this->assertTrue($result);
    }

    /** @test  */
    public function services_table_name_column_is_unique()
    {
        $this->expectException(QueryException::class);

        Service::factory()->create([
            "name" => "perbaikan web"
        ]);

        Service::factory()->create([
            "name" => "perbaikan web"
        ]);
    }

    /** @test  */
    public function services_table_icon_column_is_unique()
    {
        $this->expectException(QueryException::class);

        Service::factory()->create([
            "icon" => "default.png"
        ]);

        Service::factory()->create([
            "icon" => "default.png"
        ]);
    }
}
