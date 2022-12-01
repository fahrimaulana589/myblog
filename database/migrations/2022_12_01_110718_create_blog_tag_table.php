<?php

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('blog_tag', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Tag::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Blog::class)->constrained()->cascadeOnDelete();

            $table->nullableMorphs("taggable");
        });
    }

    public function down()
    {
        Schema::dropIfExists('taggables');
    }
};
