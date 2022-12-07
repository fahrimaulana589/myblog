<?php

use App\Models\Read;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reads', function (Blueprint $table) {
            $table->id();

            $table->integer('count')->default(1);
            $table->timestamps();

            $table->morphs('readable');

            $table->unique(['readable_type', 'readable_id']);
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignIdFor(Read::class)->nullable()->constrained()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropforeignIdFor(Read::class);
        });
        Schema::dropIfExists('reads');
    }
};
