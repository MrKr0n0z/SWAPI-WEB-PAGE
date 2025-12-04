<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->integer('swapi_id')->unique();
            $table->string('title');
            $table->integer('episode_id')->nullable();
            $table->text('opening_crawl')->nullable();
            $table->string('director')->nullable();
            $table->string('producer')->nullable();
            $table->date('release_date')->nullable();
            $table->jsonb('characters')->nullable();
            $table->jsonb('planets')->nullable();
            $table->jsonb('starships')->nullable();
            $table->jsonb('vehicles')->nullable();
            $table->jsonb('species')->nullable();
            $table->string('url')->nullable();
            $table->string('created')->nullable();
            $table->string('edited')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
