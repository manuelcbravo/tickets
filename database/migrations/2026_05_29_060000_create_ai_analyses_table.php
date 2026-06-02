<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ai_analyses')) {
            return;
        }

        Schema::create('ai_analyses', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('model')->nullable();
            $table->string('status')->default('pending')->index();
            $table->string('analysis_type')->default('full')->index();
            $table->text('summary')->nullable();
            $table->text('detected_problem')->nullable();
            $table->foreignId('suggested_type_id')->nullable()->constrained('cat_ticket_tipos')->nullOnDelete();
            $table->foreignId('suggested_priority_id')->nullable()->constrained('cat_ticket_prioridades')->nullOnDelete();
            $table->foreignId('suggested_impact_id')->nullable()->constrained('cat_ticket_impactos')->nullOnDelete();
            $table->foreignId('suggested_urgency_id')->nullable()->constrained('cat_ticket_urgencias')->nullOnDelete();
            $table->foreignId('suggested_risk_id')->nullable()->constrained('cat_ticket_riesgos')->nullOnDelete();
            $table->string('suggested_difficulty')->nullable();
            $table->jsonb('missing_information')->nullable();
            $table->text('suggested_reply')->nullable();
            $table->jsonb('suggested_checklist')->nullable();
            $table->boolean('can_answer_directly')->default(false);
            $table->boolean('requires_code_change')->default(false);
            $table->boolean('requires_quote')->default(false);
            $table->decimal('confidence', 5, 2)->nullable();
            $table->text('prompt')->nullable();
            $table->jsonb('raw_response')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('executed_at')->nullable();
            $table->timestamps();

            $table->index(['ticket_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_analyses');
    }
};
