<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cotizacion_tickets')) {
            return;
        }

        Schema::create('cotizacion_tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cotizacion_id');
            $table->uuid('ticket_id');
            $table->string('tipo_relacion', 40)->default('origen');
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->cascadeOnDelete();
            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->unique(['cotizacion_id', 'ticket_id', 'tipo_relacion'], 'cotizacion_ticket_relation_unique');
            $table->index(['ticket_id', 'tipo_relacion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizacion_tickets');
    }
};
