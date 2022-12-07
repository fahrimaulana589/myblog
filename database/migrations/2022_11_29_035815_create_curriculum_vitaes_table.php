<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('curriculum_vitaes', function (Blueprint $table) {
            $table->id();

            $table->string('photo')->unique();
            $table->string('name')->unique();
            $table->text('summary');
            $table->string('file')->unique();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('curriculum_vitaes');
    }
};
