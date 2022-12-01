<?php

namespace Tests\Unit\Models;

use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TagTest extends TestCase
{
    /** @test */
    public function tags_table_has_expected_column()
    {
        $result = Schema::hasColumns("tags",[
           "name"
        ]);

        $this->assertTrue($result);
    }

    /** @test  */
    public function tags_table_name_column_is_unique()
    {
        $this->expectException(QueryException::class);

        Tag::create([
            "name" => "hobi sehat"
        ]);

        Tag::create([
            "name" => "hobi sehat"
        ]);
    }
}
