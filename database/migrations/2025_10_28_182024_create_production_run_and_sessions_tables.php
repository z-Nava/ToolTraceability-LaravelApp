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
        Schema::create('production_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fg_model_id')->constrained('fg_models')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('line_id')->constrained('lines')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('started_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->enum('status', ['ACTIVE', 'PAUSED', 'ENDED'])->default('ACTIVE')->index();
            $table->timestamps();

            $table->index(['line_id','status']);
        });

        Schema::create('station_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_run_id')->constrained('production_runs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('station_id')->constrained('stations')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('leader_user_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamp('opened_at');
            $table->timestamp('closed_at')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->unique(['production_run_id','station_id','is_active'], 'uniq_active_session_per_station');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('station_sessions');
        Schema::dropIfExists('production_runs');
    }
};
