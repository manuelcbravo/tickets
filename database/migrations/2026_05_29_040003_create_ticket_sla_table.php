<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ticket_sla')) {
            return;
        }

        Schema::create('ticket_sla', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id')->unique();
            $table->uuid('sla_politica_id')->nullable();
            $table->foreignId('prioridad_id')->nullable()->constrained('cat_ticket_prioridades')->nullOnDelete();
            $table->timestamp('vence_primera_respuesta_at')->nullable();
            $table->timestamp('vence_resolucion_at')->nullable();
            $table->boolean('primera_respuesta_cumplida')->nullable();
            $table->boolean('resolucion_cumplida')->nullable();
            $table->timestamp('primera_respuesta_at')->nullable();
            $table->timestamp('resuelto_at')->nullable();
            $table->string('estado_sla')->default('pendiente');
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->foreign('sla_politica_id')->references('id')->on('sla_politicas')->nullOnDelete();
            $table->index('estado_sla');
            $table->index('vence_resolucion_at');
            $table->index('vence_primera_respuesta_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_sla');
    }
};
