<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sla_politica_prioridades')) {
            return;
        }

        Schema::create('sla_politica_prioridades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sla_politica_id');
            $table->foreignId('prioridad_id')->constrained('cat_ticket_prioridades')->cascadeOnDelete();
            $table->unsignedInteger('tiempo_primera_respuesta_min');
            $table->unsignedInteger('tiempo_resolucion_min');
            $table->unsignedInteger('tiempo_alerta_min')->nullable();
            $table->timestamps();

            $table->foreign('sla_politica_id')->references('id')->on('sla_politicas')->cascadeOnDelete();
            $table->unique(['sla_politica_id', 'prioridad_id'], 'sla_policy_priority_unique');
            $table->index('prioridad_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sla_politica_prioridades');
    }
};
