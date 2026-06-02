<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('proyecto_actividad_tiempos')) {
            return;
        }

        Schema::create('proyecto_actividad_tiempos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('actividad_id');
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->text('descripcion');
            $table->unsignedInteger('minutos');
            $table->date('fecha');
            $table->timestamp('iniciado_at')->nullable();
            $table->timestamp('terminado_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('actividad_id')->references('id')->on('proyecto_actividades')->cascadeOnDelete();
            $table->index(['actividad_id', 'fecha']);
            $table->index('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_actividad_tiempos');
    }
};
