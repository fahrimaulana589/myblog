<?php

namespace Tests\Unit\Models;

use App\Models\SocialMedia;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SocialMediaTest extends TestCase
{
    /** @test  */
    public function socila_media_database_has_expected_column()
    {

        $result = Schema::hasColumns("social_medias",[
            "name","icon","url"
        ]);

        $this->assertTrue($result);
    }

    /** @test  */
    public function social_media_database_name_column_is_unique()
    {
        $this->expectException(QueryException::class);

        SocialMedia::factory()->create([
           "name" => "facebook"
        ]);

        SocialMedia::factory()->create([
            "name" => "facebook"
        ]);
    }

    /** @test  */
    public function social_media_database_icon_column_is_unique()
    {
        $this->expectException(QueryException::class);

        SocialMedia::factory()->create([
            "icon" => "default.png"
        ]);

        SocialMedia::factory()->create([
            "icon" => "default.png"
        ]);
    }

    /** @test  */
    public function social_media_database_url_column_is_unique()
    {
        $this->expectException(QueryException::class);

        SocialMedia::factory()->create([
            "url" => "default.png"
        ]);

        SocialMedia::factory()->create([
            "url" => "default.png"
        ]);
    }

}
