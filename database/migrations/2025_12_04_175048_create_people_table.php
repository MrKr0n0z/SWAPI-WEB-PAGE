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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->integer('swapi_id')->unique();
            $table->string('name');
            $table->string('birth_year')->nullable();
            $table->string('eye_color')->nullable();
            $table->string('gender')->nullable();
            $table->string('hair_color')->nullable();
            $table->string('height')->nullable();
            $table->string('mass')->nullable();
            $table->string('skin_color')->nullable();
            $table->string('homeworld')->nullable();
            $table->jsonb('films')->nullable();
            $table->jsonb('species')->nullable();
            $table->jsonb('starships')->nullable();
            $table->jsonb('vehicles')->nullable();
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
        Schema::dropIfExists('people');
    }
};
