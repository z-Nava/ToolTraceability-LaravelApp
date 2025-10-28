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
        Schema::create('parsing_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('regex_pattern');              // PCRE para extraer part number
            $table->unsignedSmallInteger('part_number_group')->default(1); // grupo de captura
            $table->boolean('is_active')->default(true)->index();

            // Opcional: scope por tipo o FG si lo necesitas en el futuro
            $table->foreignId('component_type_id')->nullable()->constrained('component_types')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('fg_model_id')->nullable()->constrained('fg_models')->cascadeOnUpdate()->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('action', 100); // e.g., 'scan.create', 'station.close'
            $table->string('entity_type', 100)->nullable(); // e.g., 'component_scan'
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->index(['action','entity_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('parsing_rules');
    }
};
