<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('social_medias', function (Blueprint $table) {
            $table->id();

            $table->string('icon')->unique();
            $table->string('name')->unique();
            $table->string('url')->unique();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('social_medias');
    }
};
