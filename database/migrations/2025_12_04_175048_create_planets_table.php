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
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->integer('swapi_id')->unique();
            $table->string('name');
            $table->string('diameter')->nullable();
            $table->string('rotation_period')->nullable();
            $table->string('orbital_period')->nullable();
            $table->string('gravity')->nullable();
            $table->string('population')->nullable();
            $table->string('climate')->nullable();
            $table->string('terrain')->nullable();
            $table->string('surface_water')->nullable();
            $table->jsonb('residents')->nullable();
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
        Schema::dropIfExists('planets');
    }
};
