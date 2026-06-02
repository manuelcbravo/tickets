<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ticket_tiempos')) {
            return;
        }

        Schema::create('ticket_tiempos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ticket_id');
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->text('descripcion');
            $table->unsignedInteger('minutos');
            $table->date('fecha');
            $table->timestamp('iniciado_at')->nullable();
            $table->timestamp('terminado_at')->nullable();
            $table->boolean('es_facturable')->default(false);
            $table->string('origen')->default('manual');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->index(['ticket_id', 'fecha']);
            $table->index('usuario_id');
            $table->index('es_facturable');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_tiempos');
    }
};
