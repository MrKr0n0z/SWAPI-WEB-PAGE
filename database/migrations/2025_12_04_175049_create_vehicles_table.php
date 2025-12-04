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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('swapi_id')->unique();
            $table->string('name');
            $table->string('model')->nullable();
            $table->string('vehicle_class')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('length')->nullable();
            $table->string('cost_in_credits')->nullable();
            $table->string('crew')->nullable();
            $table->string('passengers')->nullable();
            $table->string('max_atmosphering_speed')->nullable();
            $table->string('cargo_capacity')->nullable();
            $table->string('consumables')->nullable();
            $table->jsonb('films')->nullable();
            $table->jsonb('pilots')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
};
