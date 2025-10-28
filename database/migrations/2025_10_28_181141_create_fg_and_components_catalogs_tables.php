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
        Schema::create('fg_models', function (Blueprint $table) {
            $table->id();
            $table->string('fg_code', 16)->unique();
            $table->string('description');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('component_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('part_number', 64)->unique();
            $table->string('description')->nullable();
            $table->foreignId('component_type_id')->constrained('component_types')->cascadeOnUpdate()->restrictOnDelete();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->index('component_type_id');
        });

        Schema::create('fg_bom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fg_model_id')->constrained('fg_models')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('component_id')->constrained('components')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedSmallInteger('qty_expected')->nullable();
            $table->timestamps();

            $table->unique(['fg_model_id', 'component_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fg_bom');
        Schema::dropIfExists('components');
        Schema::dropIfExists('component_types');
        Schema::dropIfExists('fg_models');
    }
};
