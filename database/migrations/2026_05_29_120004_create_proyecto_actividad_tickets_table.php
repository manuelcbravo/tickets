<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proyecto_actividad_tickets')) {
            return;
        }

        Schema::create('proyecto_actividad_tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('actividad_id');
            $table->uuid('ticket_id');
            $table->string('tipo_relacion')->default('relacionado');
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('actividad_id')->references('id')->on('proyecto_actividades')->cascadeOnDelete();
            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->unique(['actividad_id', 'ticket_id', 'tipo_relacion'], 'proyecto_actividad_ticket_unique');
            $table->index('ticket_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_actividad_tickets');
    }
};
