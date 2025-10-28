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
        Schema::create('dummy_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_run_id')->constrained('production_runs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('dummy_code', 64)->unique(); // QR viajero
            $table->enum('status', ['IN_PROGRESS','COMPLETED','SCRAPPED'])->default('IN_PROGRESS')->index();
            $table->foreignId('current_station_id')->nullable()->constrained('stations')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('component_scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_run_id')->constrained('production_runs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('station_id')->constrained('stations')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('dummy_tag_id')->constrained('dummy_tags')->cascadeOnUpdate()->cascadeOnDelete();

            $table->longText('scanned_raw'); // guardamos todo el payload escaneado
            $table->string('part_number_detected', 64)->index();
            $table->foreignId('component_id')->nullable()->constrained('components')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('component_type_id')->nullable()->constrained('component_types')->cascadeOnUpdate()->nullOnDelete();

            $table->boolean('is_valid')->default(false)->index();
            $table->string('validation_error')->nullable();

            $table->foreignId('scanned_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamp('scanned_at')->useCurrent();

            $table->timestamps();

            $table->index(['dummy_tag_id','station_id'], 'idx_scans_by_dummy_and_station');
        });

        Schema::create('station_closures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_run_id')->constrained('production_runs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('station_id')->constrained('stations')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('dummy_tag_id')->constrained('dummy_tags')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('closed_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamp('closed_at')->useCurrent();

            $table->boolean('is_complete')->default(false)->index();
            $table->json('validation_summary')->nullable();

            $table->timestamps();

            $table->unique(['dummy_tag_id','station_id'], 'uniq_closure_per_dummy_station');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('station_closures');
        Schema::dropIfExists('component_scans');
        Schema::dropIfExists('dummy_tags');
    }
};
