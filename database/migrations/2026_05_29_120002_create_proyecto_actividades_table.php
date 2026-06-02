<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proyecto_actividades')) {
            return;
        }

        Schema::create('proyecto_actividades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proyecto_id');
            $table->uuid('ticket_id')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('tipo')->default('tarea');
            $table->string('estado')->default('pendiente');
            $table->string('prioridad')->default('media');
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('reportado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_limite')->nullable();
            $table->timestamp('fecha_finalizacion')->nullable();
            $table->unsignedInteger('minutos_estimados')->nullable();
            $table->unsignedInteger('minutos_reales')->default(0);
            $table->integer('orden')->default(0);
            $table->string('kanban_column')->default('backlog');
            $table->json('tags')->nullable();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('proyecto_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->foreign('ticket_id')->references('id')->on('tickets')->nullOnDelete();
            $table->index(['proyecto_id', 'estado']);
            $table->index(['proyecto_id', 'kanban_column', 'orden']);
            $table->index('ticket_id');
            $table->index('responsable_id');
            $table->index('parent_id');
        });

        Schema::table('proyecto_actividades', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('proyecto_actividades')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_actividades');
    }
};
