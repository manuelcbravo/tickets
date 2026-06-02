<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ticket_test_results')) {
            return;
        }

        Schema::create('ticket_test_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->uuid('test_case_id')->nullable();
            $table->uuid('development_task_id')->nullable();
            $table->foreignId('executed_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('titulo');
            $table->text('pasos')->nullable();
            $table->text('resultado_esperado')->nullable();
            $table->text('resultado_obtenido')->nullable();
            $table->string('status')->default('pendiente');
            $table->text('notas')->nullable();
            $table->timestamp('executed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->foreign('test_case_id')->references('id')->on('test_cases')->nullOnDelete();
            $table->foreign('development_task_id')->references('id')->on('ticket_development_tasks')->nullOnDelete();
            $table->index(['ticket_id', 'status']);
            $table->index('test_case_id');
            $table->index('development_task_id');
            $table->index('executed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_test_results');
    }
};
