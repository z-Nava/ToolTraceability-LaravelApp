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
        Schema::create('trace_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fg_model_id')->constrained('fg_models')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedInteger('version')->default(1);
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();

            $table->index(['fg_model_id','is_active']);
        });

        Schema::create('trace_plan_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trace_plan_id')->constrained('trace_plans')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('station_id')->constrained('stations')->cascadeOnUpdate()->restrictOnDelete();

            $table->enum('requirement_mode', ['BY_TYPE','BY_PART']);
            $table->foreignId('component_type_id')->nullable()->constrained('component_types')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('part_number', 64)->nullable();

            $table->unsignedSmallInteger('min_qty')->default(1);
            $table->unsignedSmallInteger('max_qty')->nullable(); // si no hay límite, null
            $table->boolean('is_required')->default(true);

            $table->timestamps();

            $table->index(['trace_plan_id','station_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trace_plan_requirements');
        Schema::dropIfExists('trace_plans');
    }
};
