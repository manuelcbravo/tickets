<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sla_politicas')) {
            return;
        }

        Schema::create('sla_politicas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('es_default')->default(false);
            $table->time('horario_inicio')->nullable();
            $table->time('horario_fin')->nullable();
            $table->jsonb('dias_laborales')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('activo');
            $table->index('es_default');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sla_politicas');
    }
};
