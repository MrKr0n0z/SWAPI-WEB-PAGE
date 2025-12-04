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
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->integer('swapi_id')->unique();
            $table->string('name');
            $table->string('classification')->nullable();
            $table->string('designation')->nullable();
            $table->string('average_height')->nullable();
            $table->string('average_lifespan')->nullable();
            $table->string('eye_colors')->nullable();
            $table->string('hair_colors')->nullable();
            $table->string('skin_colors')->nullable();
            $table->string('language')->nullable();
            $table->string('homeworld')->nullable();
            $table->jsonb('people')->nullable();
            $table->jsonb('films')->nullable();
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
        Schema::dropIfExists('species');
    }
};
