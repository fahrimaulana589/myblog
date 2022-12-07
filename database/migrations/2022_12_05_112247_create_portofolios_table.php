<?php

use App\Models\Read;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('image')->unique();
            $table->text('content');
            $table->string('comment')->unique();

            $table->timestamps();

            $table->foreignIdFor(Read::class)->nullable()->constrained()->restrictOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('portofolios');
    }
};
