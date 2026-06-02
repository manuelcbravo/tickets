<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('folio')->unique();
            $table->uuid('cliente_id');
            $table->uuid('proyecto_id')->nullable();
            $table->uuid('proyecto_modulo_id')->nullable();
            $table->uuid('contacto_id')->nullable();
            $table->uuid('ambiente_id')->nullable();
            $table->foreignId('creado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('titulo');
            $table->text('descripcion');
            $table->foreignId('tipo_id')->constrained('cat_ticket_tipos')->restrictOnDelete();
            $table->foreignId('estado_id')->nullable()->constrained('cat_ticket_estados')->nullOnDelete();
            $table->foreignId('prioridad_id')->constrained('cat_ticket_prioridades')->restrictOnDelete();
            $table->foreignId('impacto_id')->nullable()->constrained('cat_ticket_impactos')->nullOnDelete();
            $table->foreignId('urgencia_id')->nullable()->constrained('cat_ticket_urgencias')->nullOnDelete();
            $table->foreignId('riesgo_id')->nullable()->constrained('cat_ticket_riesgos')->nullOnDelete();
            $table->string('dificultad')->nullable();
            $table->timestamp('fecha_objetivo')->nullable();
            $table->timestamp('primera_respuesta_at')->nullable();
            $table->unsignedInteger('tiempo_estimado_min')->nullable();
            $table->unsignedInteger('tiempo_real_min')->default(0);
            $table->boolean('requires_code_change')->default(false);
            $table->boolean('requires_quote')->default(false);
            $table->boolean('is_internal')->default(false);
            $table->text('resolution')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->foreignId('closed_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reopened_at')->nullable();
            $table->foreignId('reopened_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente_id')->references('id')->on('clients')->restrictOnDelete();
            $table->foreign('proyecto_id')->references('id')->on('projects')->nullOnDelete();
            $table->foreign('proyecto_modulo_id')->references('id')->on('project_modules')->nullOnDelete();
            $table->foreign('contacto_id')->references('id')->on('client_contacts')->nullOnDelete();
            $table->foreign('ambiente_id')->references('id')->on('environments')->nullOnDelete();

            $table->index('cliente_id');
            $table->index('proyecto_id');
            $table->index('responsable_id');
            $table->index('estado_id');
            $table->index('prioridad_id');
            $table->index('tipo_id');
            $table->index('created_at');
            $table->index('closed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
