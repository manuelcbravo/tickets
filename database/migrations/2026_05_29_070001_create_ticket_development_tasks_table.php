<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ticket_development_tasks')) {
            return;
        }

        Schema::create('ticket_development_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->uuid('proyecto_id')->nullable();
            $table->uuid('repositorio_id')->nullable();
            $table->foreignId('asignado_a_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('creado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('tipo')->default('bugfix');
            $table->string('estado')->default('pendiente');
            $table->string('prioridad')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('pull_request_url')->nullable();
            $table->string('commit_hash')->nullable();
            $table->unsignedInteger('estimacion_min')->nullable();
            $table->unsignedInteger('tiempo_real_min')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->foreign('proyecto_id')->references('id')->on('projects')->nullOnDelete();
            $table->foreign('repositorio_id')->references('id')->on('repositorios')->nullOnDelete();
            $table->index(['ticket_id', 'estado']);
            $table->index('proyecto_id');
            $table->index('repositorio_id');
            $table->index('asignado_a_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_development_tasks');
    }
};
